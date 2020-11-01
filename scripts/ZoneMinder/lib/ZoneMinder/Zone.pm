# ==========================================================================
#
# ZoneMinder Zone Module
# Copyright (C) 2020 ZoneMinder LLC
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
#
# ==========================================================================

package ZoneMinder::Zone;

use 5.006;
use strict;
use warnings;

require ZoneMinder::Base;
require ZoneMinder::Object;

#our @ISA = qw(Exporter ZoneMinder::Base);
use parent qw(ZoneMinder::Object);

use vars qw/ $table $primary_key %fields $serial %defaults $debug/;
$table = 'Zones';
$serial = $primary_key = 'Id';
%fields = map { $_ => $_ } qw(
  Id
  Name
  MonitorId 
  Type
  Units
  CheckMethod
  MinPixelThreshold
  MaxPixelThreshold
  MinAlarmPixels
  MaxAlarmPixels
  FilterX
  FilterY
  MinFilterPixels
  MaxFilterPixels
  MinBlobPixels
  MaxBlobPixels
  MinBlobs
  MaxBlobs
  OverloadFrames
  ExtendAlarmFrames
  );

%defaults = (
  Name                => '',
  Type => 'Active',
  Units => 'Pixels',
  CheckMethod => 'Blobs',
  MinPixelThreshold => undef,
  MaxPixelThreshold => undef,
  MinAlarmPixels => undef,
  MaxAlarmPixels => undef,
  FilterX => undef,
  FilterY => undef,
  MinFilterPixels => undef,
  MaxFilterPixels => undef,
  MinBlobPixels => undef,
  MaxBlobPixels => undef,
  MinBlobs => undef,
  MaxBlobs => undef,
  OverloadFrames => 0,
  ExtendAlarmFrames => 0,
);

1;
__END__

=head1 NAME

ZoneMinder::Zone - Perl Class for Zones

=head1 SYNOPSIS

use ZoneMinder::Zone;

=head1 AUTHOR

Isaac Connor, E<lt>isaac@zoneminder.comE<gt>

=head1 COPYRIGHT AND LICENSE

Copyright (C) 2001-2017  ZoneMinder LLC

This library is free software; you can redistribute it and/or modify
it under the same terms as Perl itself, either Perl version 5.8.3 or,
at your option, any later version of Perl 5 you may have available.


=cut
