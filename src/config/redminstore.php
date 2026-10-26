<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Serve CMS pages at the site root
    |--------------------------------------------------------------------------
    |
    | When true, a public RedminPortal page with slug "about" is shown at
    | "/about" (instead of "/page/about"). This is registered as a fallback
    | route, so it only applies when no other route matches: your own routes,
    | RedminPortal's admin/login routes and the storefront routes (/products,
    | /categories, ...) always win over a page with the same slug.
    |
    | "/page/{slug}" then redirects (301) to "/{slug}". Set to false to keep
    | pages at "/page/{slug}" only.
    |
    */
    'pages_at_root' => true,
];
