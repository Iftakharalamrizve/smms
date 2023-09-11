<?php
return [
    'core' => [
        'pool' => [
            'brick_id'          => '',
            'label'             => '',
            'account_id'        => '',
            'vcore'             => '',
            'committed_ram'     => '',
            'extra_ram'         => '',
            'disk_quota'        => '',
            'osimage'           => '',
            'vcore_ratio'       => '',
            'vd_count'          => '',
            'vd_login_policy'   => '',
            'vd_login_opt'      => '',
            'active'            => ''
        ],
        'gold_image' => [
            'account_id'    => '',
            'osimage'       => '',
            'label'         => '',
            'version'       => '',
            'note'          => ''
        ]
    ],
    'user' => [
        'account' => [
            'auth_type'         => '',
            'business_name'     => '',
            'email'             => '',
            'city'              => '',
            'contact_name'      => '',
            'contact_phone'     => '',
            'country_code'      => '',
            'auth_api'          => '',
            'auth_hash'         => '',
            'account_active'    => ''
        ],
        'local_user' => [
            'account_id'    => '',
            'user'          => '',
            'user_group'    => '',
            'alt_userid'    => '',
            'disk_quota'    => '',
            'disk_id'       => '',
            'user_active'   => ''
        ],
        'user_group' => [
            'account_id'    => '',
            'user_group'    => '',
            'pool_id'       => ''
        ]
    ],
    'provision' => [
        'thin_client' => [
            'account_id'        => '',
            'expire_date'       => '',
            'max_device'        => '',
            'key_used_count'    => ''
        ]
    ]
];