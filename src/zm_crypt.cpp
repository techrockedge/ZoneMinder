#include "zm.h"
#include "zm_crypt.h"
#include "BCrypt.hpp"
#include "jwt.h"
#include <algorithm>
#include <openssl/sha.h>
#include <string.h>

// returns username if valid, "" if not
std::pair <std::string, unsigned int> verifyToken(std::string jwt_token_str, std::string key) {
  std::string username = "";
  unsigned int token_issued_at = 0;
  try {
    // is it decodable?
    auto decoded = jwt::decode(jwt_token_str);
    auto verifier = jwt::verify()
                        .allow_algorithm(jwt::algorithm::hs256{ key })
                        .with_issuer("ZoneMinder");
  
    // signature verified?
    verifier.verify(decoded);

    // make sure it has fields we need
    if ( decoded.has_payload_claim("type") ) {
      std::string type = decoded.get_payload_claim("type").as_string();
      if ( type != "access" ) {
        Error("Only access tokens are allowed. Please do not use refresh tokens");
        return std::make_pair("", 0);
      }
    } else {
      // something is wrong. All ZM tokens have type
      Error("Missing token type. This should not happen");
      return std::make_pair("",0);
    }
    if ( decoded.has_payload_claim("user") ) {
      username  = decoded.get_payload_claim("user").as_string();
      Debug(1, "Got %s as user claim from token", username.c_str());
    } else {
      Error("User not found in claim");
      return std::make_pair("", 0);
    }

    if ( decoded.has_payload_claim("iat") ) {
      token_issued_at = (unsigned int) (decoded.get_payload_claim("iat").as_int());
      Debug(1, "Got IAT token=%u", token_issued_at);
    } else {
      Error("IAT not found in claim. This should not happen");
      return std::make_pair("", 0);
    }
  } // try
  catch ( const std::exception &e ) {
      Error("Unable to verify token: %s", e.what());
      return std::make_pair("", 0);
  }
  catch (...) {
     Error("unknown exception");
     return std::make_pair("", 0);
  }
  return std::make_pair(username, token_issued_at);
}

bool verifyPassword(const char *username, const char *input_password, const char *db_password_hash) {
  bool password_correct = false;
  if ( strlen(db_password_hash) < 4 ) {
    // actually, shoud be more, but this is min. for next code
    Error("DB Password is too short or invalid to check");
    return false;
  }
  if ( db_password_hash[0] == '*' ) {
    // MYSQL PASSWORD
    Debug(1, "%s is using an MD5 encoded password", username);
    
    SHA_CTX ctx1, ctx2;
    unsigned char digest_interim[SHA_DIGEST_LENGTH];
    unsigned char digest_final[SHA_DIGEST_LENGTH];

    //get first iteration
    SHA1_Init(&ctx1);
    SHA1_Update(&ctx1, input_password, strlen(input_password));
    SHA1_Final(digest_interim, &ctx1);

    //2nd iteration
    SHA1_Init(&ctx2);
    SHA1_Update(&ctx2, digest_interim,SHA_DIGEST_LENGTH);
    SHA1_Final (digest_final, &ctx2);

    char final_hash[SHA_DIGEST_LENGTH * 2 +2];
    final_hash[0] = '*';
    //convert to hex
    for ( int i = 0; i < SHA_DIGEST_LENGTH; i++ )
      sprintf(&final_hash[i*2]+1, "%02X", (unsigned int)digest_final[i]);
    final_hash[SHA_DIGEST_LENGTH *2 + 1] = 0;

    Debug(1, "Computed password_hash:%s, stored password_hash:%s", final_hash, db_password_hash);
    password_correct = (strcmp(db_password_hash, final_hash)==0);
  } else if (
      (db_password_hash[0] == '$')
      &&
      (db_password_hash[1] == '2')
      &&
      (db_password_hash[3] == '$')
      ) {
    // BCRYPT 
    Debug(1, "%s is using a bcrypt encoded password", username);
    BCrypt bcrypt;
    std::string input_hash = bcrypt.generateHash(std::string(input_password));
    password_correct = bcrypt.validatePassword(std::string(input_password), std::string(db_password_hash));
  } else if ( strncmp(db_password_hash, "-ZM-",4) == 0 ) {
    Error("Authentication failed - migration of password not complete. Please log into web console for this user and retry this operation");
    return false;
  } else {
    Warning("%s is using a plain text (not recommended) or scheme not understood", username);
    password_correct = (strcmp(input_password, db_password_hash) == 0);
  } 
  
  return password_correct;
}
