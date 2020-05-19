package WSDiscovery::Types::ResolveMatchesType;
use strict;
use warnings;


__PACKAGE__->_set_element_form_qualified(0);

sub get_xmlns { 'http://docs.oasis-open.org/ws-dd/ns/discovery/2009/01' };

our $XML_ATTRIBUTE_CLASS;
undef $XML_ATTRIBUTE_CLASS;

sub __get_attr_class {
    return $XML_ATTRIBUTE_CLASS;
}

use Class::Std::Fast::Storable constructor => 'none';
use base qw(SOAP::WSDL::XSD::Typelib::ComplexType);

Class::Std::initialize();

{ # BLOCK to scope variables

my %ResolveMatch_of :ATTR(:get<ResolveMatch>);

__PACKAGE__->_factory(
    [ qw(        ResolveMatch

    ) ],
    {
        'ResolveMatch' => \%ResolveMatch_of,
    },
    {
        'ResolveMatch' => 'WSDiscovery::Types::ResolveMatchType',
    },
    {

        'ResolveMatch' => 'ResolveMatch',
    }
);

} # end BLOCK








1;


=pod

=head1 NAME

WSDiscovery::Types::ResolveMatchesType

=head1 DESCRIPTION

Perl data type class for the XML Schema defined complexType
ResolveMatchesType from the namespace http://docs.oasis-open.org/ws-dd/ns/discovery/2009/01.






=head2 PROPERTIES

The following properties may be accessed using get_PROPERTY / set_PROPERTY
methods:

=over

=item * ResolveMatch




=back


=head1 METHODS

=head2 new

Constructor. The following data structure may be passed to new():

 { # WSDiscovery::Types::ResolveMatchesType
   ResolveMatch =>  { # WSDiscovery::Types::ResolveMatchType
     EndpointReference =>  { # WSDiscovery::Types::EndpointReferenceType
       Address =>  { value => $some_value },
       ReferenceParameters =>  { # WSDiscovery::Types::ReferenceParametersType
       },
       Metadata =>  { # WSDiscovery::Types::MetadataType
       },
     },
     Types => $some_value, # QNameListType
     Scopes =>  { value => $some_value },
     XAddrs => $some_value, # UriListType
     MetadataVersion =>  $some_value, # unsignedInt
   },
 },




=head1 AUTHOR

Generated by SOAP::WSDL

=cut

