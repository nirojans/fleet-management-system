/*
 *  Copyright (c) 2005-2010, WSO2 Inc. (http://www.wso2.org) All Rights Reserved.
 *
 *  WSO2 Inc. licenses this file to you under the Apache License,
 *  Version 2.0 (the "License"); you may not use this file except
 *  in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var BASE_URL;


/*Application configurations*/
var unDispatchedOrders = {};

function getBaseURL() {
    if (BASE_URL === 'undefined') {
        return null;
    }
    return BASE_URL;
}

function setBaseURL(url) {
    BASE_URL = url;
    initApplicationOptions();
}

var ApplicationOptions;

function initApplicationOptions() {
    ApplicationOptions = {
        colors: {
            states: {
                NORMAL: 'blue',
                WARNING: 'orange',
                OFFLINE: 'grey',
                ALERTED: 'red',
                UNKNOWN: 'black' // TODO: previous color #19FFFF , change this if black is not user friendly ;)
            },
            application: {
                header: 'grey'
            }
        },
        constance: {
            BASE_URL: getBaseURL(),
            WEBSOCKET_URL: '192.168.0.2',
            WEBSOCKET_PORT: '8080',

            SPEED_HISTORY_COUNT: 20,
            NOTIFY_INFO_TIMEOUT: 1000,
            NOTIFY_SUCCESS_TIMEOUT: 1000,
            NOTIFY_WARNING_TIMEOUT: 3000,
            NOTIFY_DANGER_TIMEOUT: 5000
        },
        messages: {
            app: {}
        },
        leaflet: {
            iconUrls: {
                normalIcon: getBaseURL() + 'assets/img/markers/car_top_online.png',
                alertedIcon: getBaseURL() + 'assets/img/markers/car_top_offline.png',
                offlineIcon: getBaseURL() + 'assets/img/markers/arrow_offline.png',
                warningIcon: getBaseURL() + 'assets/img/markers/arrow_warning.png',
                defaultIcon: getBaseURL() + 'assets/img/markers/car_top_online.png',
                resizeIcon: getBaseURL() + 'assets/img/markers/resize.png'

            },
            iconSize: [36, 36]
        }
    };
}

initApplicationOptions();
