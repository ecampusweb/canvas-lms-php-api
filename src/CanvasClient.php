<?php

namespace Ecampusweb\CanvasLmsPhpApi;


class CanvasClient
{

    private $options = [
        'base_url' => '',
        'token'    => '',
        'per_page' => '50',
    ];

    private $getRequests = [
        'listAccounts' => [
            'path' => '/api/v1/accounts'
        ],
        'getAccount'   => [
            'path' => '/api/v1/accounts/:id'
        ],
    ];


    public function __call($name, $arguments)
    {
        preg_replace_callback(
            '/:(\w+)/',
            function ($matches) use ($arguments) {

                if (!isset($arguments[0][$matches[1]])) {
                    throw new \Exception("Required argument not set: " . $matches[1]);
                }

                return $arguments[0][$matches[1]];
            },
            $this->getRequests[$name]['path']
        );
    }

    public function init(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    public function listAccounts()
    {
        return [
            'method' => 'GET',
            'url'    => '/api/v1/accounts',
        ];
    }
}