# Offline location catalog

`southern_leyte_locations.json` bundles the Southern Leyte municipality/city
and barangay names used by the report form. It contains 19 municipality/city
entries and 500 barangays, retrieved on 2026-11-04 from the same PSGC API used
by the Laravel website:

- https://psgc.gitlab.io/api/provinces/086400000/cities-municipalities/
- https://psgc.gitlab.io/api/provinces/086400000/barangays/

Barangays are joined by `cityCode` or `municipalityCode`, never by list order.
The app loads this asset before showing the report form, regardless of
authentication or connectivity. Server municipality names are merged with
the bundled list; an empty server list does not erase the offline choices.
Maasin and Maasin City are recognized as aliases of City of Maasin.

To refresh, fetch both endpoints, join by the PSGC codes, validate that every
barangay has a parent, and replace the JSON asset while retaining its schema.
