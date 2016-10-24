<?php
/**
 * Helper for working with individual Validic users.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 * @author     Aleksandar Jocic <aleks.jocic@validic.com>
 * @copyright  2016 Motivation Science, Inc.
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0
 * @since      File available since Release 1.0
 * @link       https://github.com/gotun/ValidicPHP
 */
namespace Validic\User;

use Validic\BuildRequestOptions;
use Validic\Endpoint;
use Validic\Endpoint\Endpoints;
use Validic\Endpoint\ShortEndpoints;

/**
 * Provides convenience functions for manipulating individual Validic users.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 */
class User
{

    /**
     * The user's Validic id.
     * 
     * @var string
     */
    public $validic_id;

    /**
     * The user's authentication token.
     * 
     * @var string
     */
    public $authentication_token;

    /**
     * The user's uid.
     *
     * @var string
     */
    public $uid;

    /**
     * The user's gender.
     *
     * @var string
     */
    public $gender;

    /**
     * The user's location.
     *
     * @var string|number
     */
    public $location;

    /**
     * The user's birth year.
     *
     * @var string|number
     */
    public $birth_year;

    /**
     * The user's country.
     *
     * @var string
     */
    public $country;

    /**
     * The user's weight.
     *
     * @var number
     */
    public $weight;

    /**
     * The user's height.
     *
     * @var number
     */
    public $height;

    /**
     * The user's applications.
     *
     * @var array
     */
    protected $applications = [];

    /**
     * The user's devices.
     *
     * @var array
     */
    protected $devices = [];

    /**
     * Constructs a Validic user helper.
     *
     * @param array $options            
     * @see \Validic\User\UserOptions
     */
    public function __construct(array $options = [])
    {
        // set the Validic id
        $this->validic_id = isset($options[UserOptions::VALIDIC_ID]) ? $options[UserOptions::VALIDIC_ID] : null;
        
        // set the authentcation token
        $this->authentication_token = isset($options[UserOptions::AUTHENTICATION_TOKEN]) ? $options[UserOptions::AUTHENTICATION_TOKEN] : null;
        
        // set the uid
        $this->uid = isset($options[UserOptions::UID]) ? $options[UserOptions::UID] : null;
        
        // set the birth year
        $this->birth_year = isset($options[UserOptions::BIRTH_YEAR]) ? $options[UserOptions::BIRTH_YEAR] : null;
        
        // set the gender
        $this->gender = isset($options[UserOptions::GENDER]) ? $options[UserOptions::GENDER] : null;
        
        // set the country
        $this->country = isset($options[UserOptions::COUNTRY]) ? $options[UserOptions::COUNTRY] : null;
        
        // set the location
        $this->location = isset($options[UserOptions::LOCATION]) ? $options[UserOptions::LOCATION] : null;
        
        // set the weight
        $this->weight = isset($options[UserOptions::WEIGHT]) ? $options[UserOptions::WEIGHT] : null;
        
        // set the height
        $this->height = isset($options[UserOptions::HEIGHT]) ? $options[UserOptions::HEIGHT] : null;
    }

    /**
     * Gets the user's devices from their profile. The
     * buildAndSendRequestProfile must be called for this field to be populated.
     * 
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Gets the user's connected applications from their profile. The
     * buildAndSendRequestProfile must be called for this field to be populated.
     *
     * @return array
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Builds basic options for creating the user.
     *
     * @throws \Exception Requires the user's uid to be set.
     * @return array The UsersEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestCreate()
     */
    function buildOptionsCreate()
    {
        if (empty($this->uid))
            throw new \Exception("A uid is required.");
        
        $options = [
            BuildRequestOptions::VERB => \Validic\RequestVerbs::POST,
            BuildRequestOptions::BODY => [
                'user' => [
                    UserOptions::UID => (string) $this->uid,
                    'profile' => [
                        UserOptions::BIRTH_YEAR => $this->birth_year,
                        UserOptions::LOCATION => $this->location,
                        UserOptions::COUNTRY => $this->country,
                        UserOptions::WEIGHT => $this->weight,
                        UserOptions::HEIGHT => $this->height,
                        UserOptions::GENDER => $this->gender
                    ]
                ]
            ]
        ];
        
        return [
            new Endpoint\UsersEndpoint(),
            $options
        ];
    }

    /**
     * Builds basic options for deleting the user.
     *
     * @throws \Exception Requires the user's Validic id to be set.
     * @return array The UserEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestDelete()
     */
    public function buildOptionsDelete()
    {
        if (empty($this->validic_id))
            throw new \Exception("A Validic id is required.");
        
        return [
            new Endpoint\UserEndpoint(),
            [
                BuildRequestOptions::USER_ID => $this->validic_id,
                BuildRequestOptions::VERB => \Validic\RequestVerbs::DELETE
            ]
        ];
    }

    /**
     * Builds basic options for retrieving the user's Validic id from their
     * authentication token.
     *
     * @throws \Exception Requires the user's uid to be set.
     * @return array The MeEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestIdFromAuthToken()
     */
    public function buildOptionsIdFromAuthToken()
    {
        if (empty($this->authentication_token))
            throw new \Exception("An authentication token is required.");
        
        return [
            new Endpoint\MeEndpoint(),
            [
                BuildRequestOptions::AUTHENTICATION_TOKEN => $this->authentication_token
            ]
        ];
    }

    /**
     * Builds basic options for retrieving the user's Validic id from their uid.
     *
     * @throws \Exception Requires the user's uid to be set.
     * @return array The UsersEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestIdFromUid()
     */
    public function buildOptionsIdFromUid()
    {
        if (empty($this->uid))
            throw new \Exception("A uid is required.");
        
        return [
            new Endpoint\UsersEndpoint(),
            [
                BuildRequestOptions::FILTERS => [
                    new \Validic\Filter\UidFilter($this->uid)
                ]
            ]
        ];
    }

    /**
     * Builds basic options for retrieving the user's marketplace apps.
     *
     * @param string $redirect_uri            
     * @param string $format_redirect            
     * @throws \Exception Requires the user's authentication token to be set.
     * @return array The UserAppsEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestMarketplaceApps()
     */
    public function buildOptionsMarketplaceApps($redirect_uri = "", $format_redirect = "")
    {
        if (empty($this->authentication_token))
            throw new \Exception("An authentication token is required.");
        
        $options = [
            BuildRequestOptions::AUTHENTICATION_TOKEN => $this->authentication_token
        ];
        
        $filters = [];
        if (! empty($redirect_uri))
            array_push($filters, new \Validic\Filter\RedirectUriFilter($redirect_uri));
        if (! empty($format_redirect))
            array_push($filters, new \Validic\Filter\FormatRedirectFilter($format_redirect));
        if (! empty($filters))
            $options[BuildRequestOptions::FILTERS] = $filters;
        
        return [
            new Endpoint\UserAppsEndpoint(),
            $options
        ];
    }

    /**
     * Builds basic options for retrieving the user's profile information.
     *
     * @throws \Exception Requires the user's authentication token to be set.
     * @return array The ProfileEndpoint and BuildRequestOptions needed by the \Validic\Client
     * @see \Validic\User\User::buildAndSendRequestProfile()
     */
    public function buildOptionsProfile()
    {
        if (empty($this->authentication_token))
            throw new \Exception("An authentication token is required.");
        
        return [
            new Endpoint\ProfileEndpoint(),
            [
                BuildRequestOptions::AUTHENTICATION_TOKEN => $this->authentication_token
            ]
        ];
    }

    /**
     * Builds basic options for refreshing the user's token.
     *
     * @throws \Exception Requires the user's Validic id to be set.
     * @return array The RefreshTokenEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestRefreshToken()
     */
    public function buildOptionsRefreshToken()
    {
        if (empty($this->validic_id))
            throw new \Exception("A Validic id is required.");
        
        return [
            new Endpoint\RefreshTokenEndpoint(),
            [
                BuildRequestOptions::USER_ID => $this->validic_id
            ]
        ];
    }

    /**
     * Builds basic options for suspending the user.
     *
     * @throws \Exception Requires the user's Validic id to be set.
     * @return array The UserEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestSuspend()
     */
    public function buildOptionsSuspend()
    {
        return $this->suspendUserOptions(1);
    }

    /**
     * Builds basic options for unsuspending the user.
     *
     * @throws \Exception Requires the user's Validic id to be set.
     * @return array The UserEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestUnsuspend()
     */
    public function buildOptionsUnsuspend()
    {
        return $this->suspendUserOptions(0);
    }

    /**
     * Builds basic options for updating the user.
     *
     * @throws \Exception Requires the user's Validic id to be set.
     * @return array The UserEndpoint and BuildRequestOptions needed by the \Validic\Client.
     * @see \Validic\User\User::buildAndSendRequestUpdate()
     */
    public function buildOptionsUpdate()
    {
        if (empty($this->validic_id))
            throw new \Exception("A Validic id is required.");
        
        $options = [
            BuildRequestOptions::USER_ID => $this->validic_id,
            BuildRequestOptions::VERB => \Validic\RequestVerbs::PUT,
            BuildRequestOptions::BODY => [
                'user' => [
                    'profile' => [
                        UserOptions::BIRTH_YEAR => $this->birth_year,
                        UserOptions::LOCATION => $this->location,
                        UserOptions::COUNTRY => $this->country,
                        UserOptions::WEIGHT => $this->weight,
                        UserOptions::HEIGHT => $this->height,
                        UserOptions::GENDER => $this->gender
                    ]
                ]
            ]
        ];
        
        // Don't update the uid if not set
        if (isset($this->uid))
            $options[BuildRequestOptions::BODY]['user'][UserOptions::UID] = (string) $this->uid;
        
        return [
            new Endpoint\UserEndpoint(),
            $options
        ];
    }

    /**
     * Creates the user in Validic and captures the Validic id and
     * authentication token.
     *
     * @param \Validic\Client $client
     * @param boolean $ignore_user_abort default:true
     * @throws \Exception Requires the user's uid to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsCreate()
     */
    public function buildAndSendRequestCreate(\Validic\Client $client, $ignore_user_abort = true)
    {
        ignore_user_abort($ignore_user_abort);
        
        list ($endpoint, $options) = $this->buildOptionsCreate();
        
        $response = $client->buildAndSendRequest($endpoint, $options);
        
        if ($response->succeeded()) {
            $json = $response->getJson();
            
            $this->authentication_token = $json['user']['access_token'];
            $this->validic_id = $json['user']['_id'];
        }
        
        return $response;
    }

    /**
     * Deletes the user from Validic.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's Validic id to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsDelete()
     */
    public function buildAndSendRequestDelete(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsDelete($client);
        
        return $client->buildAndSendRequest($endpoint, $options);
    }

    /**
     * Recovers the user's Validic id from their uid. If no user was found with
     * the uid, the Validic id will be null. If there are multiple Validic users
     * with the same uid, the first one returned will be used.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's uid to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsIdFromUid()
     */
    public function buildAndSendRequestIdFromUid(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsIdFromUid();
        
        $response = $client->buildAndSendRequest($endpoint, $options);
        
        if (! $response->succeeded())
            return $response;
        
        $json = $response->getJson();
        
        if (isset($json[Endpoints::USERS]) && count($json[Endpoints::USERS]) > 0) {
            $this->validic_id = $json[Endpoints::USERS][0]['_id'];
        }
        
        return $response;
    }

    /**
     * Recovers the user's Validic id from their authentication token.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's authentication token to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsIdFromAuthToken()
     */
    public function buildAndSendRequestIdFromAuthToken(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsIdFromAuthToken();
        
        $response = $client->buildAndSendRequest($endpoint, $options);
        
        if (! $response->succeeded())
            return $response;
        
        $json = $response->getJson();
        
        if (isset($json[ShortEndpoints::ME])) {
            $this->validic_id = $json[ShortEndpoints::ME]['_id'];
        }
        
        return $response;
    }

    /**
     * Sends a request to retrieve the user's apps.json response with the
     * the redirect_uri and format_redirect parameters populated on the sync,
     * unsync and refresh urls.
     *
     * Any default filters set in the client will be used. The response only
     * returns the first page. If the limit is set too low, some apps may not be
     * returned.
     *
     * @param \Validic\Client $client
     * @param string $redirect_uri
     * @param string $format_redirect default:json
     * @throws \Exception Requires the user's authentication token to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsMarketplaceApps()
     */
    public function buildAndSendRequestMarketplaceApps(\Validic\Client $client, $redirect_uri = "", $format_redirect = "json")
    {
        list ($endpoint, $options) = $this->buildOptionsMarketplaceApps($redirect_uri, $format_redirect);
        
        return $client->buildAndSendRequest($endpoint, $options);
    }

    /**
     * Gets the user's profile from Validic. This method populate all info
     * available in the user's profile including applications and devices.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's authentication token to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsProfile()
     */
    public function buildAndSendRequestProfile(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsProfile();
    
        $response = $client->buildAndSendRequest($endpoint, $options);
    
        if (! $response->succeeded())
            return $response;
    
        $json = $response->getJson()[ShortEndpoints::PROFILE];
    
        $this->validic_id = $json['_id'];
        $this->uid = $json['uid'];
    
        $this->gender = $json[UserOptions::GENDER];
        $this->country = $json[UserOptions::COUNTRY];
        $this->birth_year = $json[UserOptions::BIRTH_YEAR];
        $this->height = $json[UserOptions::HEIGHT];
        $this->weight = $json[UserOptions::WEIGHT];
        $this->location = $json[UserOptions::LOCATION];
    
        $this->devices = $json['devices'];
    
        foreach ($json['applications'] as $application) {
            array_push($this->applications, $application['name']);
        }
    
        return $response;
    }
    
    /**
     * Refreshes the user's authentication token. The old token becomes invalid.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's Validic id to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsRefreshToken()
     */
    public function buildAndSendRequestRefreshToken(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsRefreshToken();
        
        $response = $client->buildAndSendRequest($endpoint, $options);
        
        if (! $response->succeeded())
            return $response;
        
        $json = $response->getJson();
        
        if (isset($json[Endpoints::USER])) {
            $this->authentication_token = $json[Endpoints::USER]['authentication_token'];
        }
        
        return $response;
    }

    /**
     * Suspends the user in Validic. This action unsyncs all apps and prevents
     * new apps from being connected.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's Validic id to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsSuspend()
     */
    public function buildAndSendRequestSuspend(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsSuspend();
        
        return $client->buildAndSendRequest($endpoint, $options);
    }

    /**
     * Unsuspends the user in Validic.
     *
     * @param \Validic\Client $client
     * @throws \Exception Requires the user's Validic id to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsUnsuspend()
     */
    public function buildAndSendRequestUnsuspend(\Validic\Client $client)
    {
        list ($endpoint, $options) = $this->buildOptionsUnsuspend();
        
        return $client->buildAndSendRequest($endpoint, $options);
    }

    /**
     * Updates the user in Validic.
     *
     * @param \Validic\Client $client
     * @param boolean $ignore_user_abort default:true
     * @throws \Exception Requires the user's Validic id to be set.
     * @return \Validic\Response
     * @see \Validic\User\User::buildOptionsUpdate()
     */
    public function buildAndSendRequestUpdate(\Validic\Client $client, $ignore_user_abort = true)
    {
        ignore_user_abort($ignore_user_abort);
        
        list ($endpoint, $options) = $this->buildOptionsUpdate();
        
        $response = $client->buildAndSendRequest($endpoint, $options);
        
        return $response;
    }

    /**
     * Builds basic options for suspending or unsuspending the user.
     *
     * @throws \Exception Requires the user's Validic id to be set.
     * @return array The UserEndpoint and BuildRequestOptions needed by the \Validic\Client
     * @see \Validic\User\User::buildOptionsSuspend()
     * @see \Validic\User\User::buildOptionsUnsuspend()
     */
    private function suspendUserOptions($state)
    {
        if (empty($this->validic_id))
            throw new \Exception("A Validic id is required.");
        
        $options = [
            BuildRequestOptions::USER_ID => $this->validic_id,
            BuildRequestOptions::VERB => \Validic\RequestVerbs::PUT,
            BuildRequestOptions::BODY => [
                'suspend' => $state
            ]
        ];
        
        return [
            new Endpoint\UserEndpoint(),
            $options
        ];
    }
}