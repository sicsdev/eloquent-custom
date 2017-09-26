# Changes History

1.0.6
-----
User model utilizes Authorizable trait
Add base job class, queueable by default

1.0.5
-----
Class Saritasa\Database\Eloquent\Utils\Query with helper functions to work with Eloquent queries

1.0.4
-----
Remove User->setProfileVisible method and two sets of visible fields. Should be done via Transformer

1.0.3
-----
Update User model to use saritasa/roles-simple
Publish migrations in console only

1.0.2
-----
Fix namespace, remove unneeded migrations

1.0.1
-----
Fixes

1.0.0
-----
Initial version: Entity inheritor for Eloquent Model. Allows to set default values.
