# cmsuser

This provides the following CiviRules entities:

- Condition: "Contact has CMS user".
- Action: "Create CMS User". *CMS username is set to contact email address*.

This provides the following API3 functions:
- `Cmsuser.create` to create a CMS user for a contact.
- `Cmsuser.get` to get the CMS user account for a contact.

If a user is created on Drupal 7 an account activation email is automatically sent.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Installation

See: https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/#installing-a-new-extension
