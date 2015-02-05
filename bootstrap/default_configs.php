<?php
# Default Configs
#
# These are the configs that can be deleted from config/default.yml
# The app relies on them existing so we don't want to assume they
# exist in a config file.

$app['http_cache.enabled'] = false;
$app['http_cache.default_ttl'] = 3600;