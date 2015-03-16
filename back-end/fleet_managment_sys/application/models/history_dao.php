<?php

class History_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'history')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createBooking($bookingArray)
    {
        $collection = $this->get_collection();
        $collection->insert($bookingArray);
        return;
    }

    function getBooking($objId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('_id' => new MongoId($objId));

        return $collection->findOne($searchQuery);
    }

    function getBookingsByTown($town)
    {
        $collection = $this->get_collection();
        $result = $collection->find(array("address.town" => new MongoRegex('/' . $town . '/i')));
        $result->limit(20);
        $data = array();
        foreach ($result as $doc) {
            $data['data'][] = $doc;
        }
        return $data;
    }

    function getBookingByRefId($refId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('refId' => (int)$refId);
        return $collection->findOne($searchQuery);
    }

    function getBookings($limit = null, $start = null, $history = null)
    {
        $collection = $this->get_collection();
        $bookings_with_cab = array();

        if ($history) {
            //aggregate( { $project: { year: { $year: "$bookTime" } , bookTime: 1} }, {$match : { year: new Date().getFullYear()} } )
            $match = array();
            $name = '';
            $date = new DateTime();

            switch ($history) {
                case 'year':
                    $name = 'year';
                    $match[$name] = (int)$date->format('Y');
                    break;
                case 'month':
                    $name = 'month';
                    $match[$name] = (int)$date->format('m');
                    break;
                case 'week':
                    $name = 'week';
                    $match[$name] = (int)$date->format('W');
                    break;
            }

            $key = '$' . $name;

            $pipeline = array();
            $pipeline[] = array(
                '$project' => array(
                    $name => array(
                        $key => '$bookTime'
                    ),
                    'refId' => 1
                )
            );
            $pipeline[] = array(
                '$sort' => array('bookTime' => -1)
            );
            $pipeline[] = array(
                '$match' => $match
            );

            if ($limit or $start) {
                $pipeline[] = array(
                    '$skip' => $start
                );
                $pipeline[] = array(
                    '$limit' => $limit
                );
            }
            $bookings = $collection->aggregate($pipeline);

            foreach ($bookings['result'] as $booking) {
                $bk = $this->getBookingByRefId($booking['refId']);
                $cab = $this->cab_dao->getCab($bk['cabId']);
                $bk['cab'] = $cab;
                array_push($bookings_with_cab, $bk);
            }
        } else {
            $bookings = $collection->find()->sort(array('bookTime' => -1))->skip($start)->limit($limit);
            foreach ($bookings as $booking) {
                $cab = $this->cab_dao->getCab($booking['cabId']);
                $booking['cab'] = $cab;
                array_push($bookings_with_cab, $booking);
            }
        }
        return $bookings_with_cab;
    }


    function bookingsCount()
    {
        $collection = $this->get_collection();
        $count = $collection->count();
        return $count;
    }

    /**
     * @param $id = mongoId String
     * @return php array of booking
     */
    function getBookingByMongoId($id)
    {

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery = array('_id' => new MongoId($id));

        return $collection->findOne($searchQuery);
    }

    function getBookingsByDateRange($startDate, $endDate, $userId, $cabId)
    {
        $collection = $this->get_collection();
        if ($userId == "0" && $cabId == "0") {
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate));
        } else if ($userId != "0" && $cabId == "0") {
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate), 'driverId' => new MongoInt32($userId));
        } else if ($userId == "0" && $cabId != "0") {
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate), 'cabId' => new MongoInt32($cabId));
        } else if ($userId != "0" && $cabId != "0") {
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate), 'driverId' => new MongoInt32($userId), 'cabId' => new MongoInt32($cabId));
        }
        return $collection->find($searchQuery);//var_dump($cursor);

    }

    /**
     * @param $id = mongoId String
     * @return php array of booking
     */
    function getBookingFeeByMongoId($id)
    {

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery = array('_id' => new MongoId($id), 'bookingCharge' => '-');
        $cursor = $collection->find($searchQuery);
        $bookings = array();
        foreach ($cursor as $booking) {
            $bookings[] = $booking;
        }
        return $bookings;
    }

    /**
     * @return array
     */
    function getBookingFees()
    {

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');
        $searchQuery = array('vType' => array('$nin' => array('nano')), 'status' => 'END', 'bookingCharge' => '-');//'vType' => array('$not'=>'nano'),'vType' => array('$nin'=>array('nano')),
        //$searchQuery= array('$nin'=>array('bookingCharge'=>'-'));
        $cursor = $collection->find($searchQuery);//var_dump($cursor);
        $bookings = array('data' => array());
        foreach ($cursor as $booking) {
            $bookings['data'][] = $booking;
        }
        return $bookings;
    }

    /**
     * @param $id
     * @return array
     */
    function getBookingFeesByDriverId($id)
    {

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');
        $searchQuery = array('vType' => array('$nin' => array('nano')), 'status' => 'END', 'driverId' => new MongoInt32($id), 'bookingCharge' => '-');
        $cursor = $collection->find($searchQuery);
        $bookings = array('data' => array());
        foreach ($cursor as $booking) {
            $bookings['data'][] = $booking;
        }
        return $bookings;
    }

    function updateBooking($objId, $data)
    {
        $collection = $this->get_collection();

        $searchQuery = array('_id' => new MongoId($objId));
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value) {
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    function updateBookingCharge($objId, $bookingCharge)
    {
        $collection = $this->get_collection();

        $searchQuery = array('_id' => new MongoId($objId));
        $collection->update($searchQuery, array('$set' => array('bookingCharge' => intval($bookingCharge))));
    }

    function updateBookingChargeByRef($refId, $bookingCharge)
    {
        $collection = $this->get_collection();
        $searchQuery = array('refId' => new MongoInt32($refId));
        $collection->update($searchQuery, array('$set' => array('bookingCharge' => intval($bookingCharge))));
    }

    function get_driver_and_cro_by_refId($refId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('refId' => $refId);
        $driver_cro = $collection->findOne($searchQuery, array('driverId' => true, 'croId' => true));
        return $driver_cro;
    }

    function getHireSummaryByDate($date)
    {

        $collection = $this->get_collection();
        $searchQuery = array('bDate' => $date);
        $bookings = $collection->find($searchQuery);

        return $bookings;
    }

    function getHireTypesSummaryByDate($startTime, $endTime, $userId)
    {

        $collection = $this->get_collection();
        $searchQuery = array('bookTime' => array('$gt' => $startTime, '$lte' => $endTime), 'driverId' => new MongoInt32($userId));
        $bookings = $collection->find($searchQuery);
        $hireTypes = array('data' => array('hires' => 0, 'cancel' => 0, 'drop' => 0, 'bothway' => 0, 'guestCarrier' => 0, 'outside' => 0, 'day' => 0, 'normal' => 0, 'cabId' => -1));
        foreach ($bookings as $booking) {
            $hireTypes['data']['hires']++;
            if ($booking['status'] == 'CANCEL' || $booking['status'] == 'DIS_CANCEL') {
                $hireTypes['data']['cancel']++;
            }
            if ($booking['packageType'] == 'drop') {
                $hireTypes['data']['drop']++;
            } else if ($booking['packageType'] == 'bothWay') {
                $hireTypes['data']['bothway']++;
            } else if ($booking['packageType'] == 'guestCarrier') {
                $hireTypes['data']['guestCarrier']++;
            } else if ($booking['packageType'] == 'outSide') {
                $hireTypes['data']['outside']++;
            } else if ($booking['packageType'] == 'day') {
                $hireTypes['data']['day']++;
            } else {
                $hireTypes['data']['normal']++;
            }
            $hireTypes['data']['cabId'] = $booking['cabId'];
        }
        return $hireTypes;
    }
}