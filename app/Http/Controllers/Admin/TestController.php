<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicAlert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Debugbar;
use MongoDB\Model\BSONDocument;
use Illuminate\Support\Facades\Gate;


class TestController extends Controller
{
    //

    public function test()
    {
        // Gate::authorize('add-public-alerts');
        $this->authorize('create', PublicAlert::class);
        PublicAlert::create([]);
    }
    public function testv1()
    {
        // $user = User::raw()->aggregate([
        //     [
        //     '$match' => [
        //         "email" => "rafy199889@gmail.com"
        //     ]
        // ]
        // ]);

        // $usert = User::aggregate([
        //         [
        //         '$match' => [
        //             "email" => "rafy199889@gmail.com"
        //         ]
        //     ],[
        //         '$lookup' => [
        //             "localField" => "role.id",
        //             "from" => "roles",
        //             "foreignField" => "_id",
        //             "as" => "roles"
        //         ]
        //     ], [
        //         '$lookup' => [
        //             "localField" => "roles.permissions",
        //             "from" => "permissions",
        //             "foreignField" => "_id",
        //             "as" => "permissionslist"
        //         ]
        //     ]
        //     ]);
        $usera = DB::collection('users')->raw(function($collection)
        {
            return $collection->aggregate([
                [
                '$match' => [
                    "email" => "rafy199889@gmail.com"
                ]
            ],[
                '$lookup' => [
                    "localField" => "role.id",
                    "from" => "roles",
                    "foreignField" => "_id",
                    "as" => "roles"
                ]
            ], [
                '$lookup' => [
                    "localField" => "roles.permissions",
                    "from" => "permissions",
                    "foreignField" => "_id",
                    "as" => "permissionslist"
                ]
                ],
            ]);
        });


        $usert = User::find('604a43a6c279000004002b32');
        (( $usera->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array'])));
        dd($usera->toArray());
        dd($usert);
        foreach ($usera as $document) {
            dd($document);
        }
        dd();


        // $current = $usera->toArray()->bsonUnserialize;

        //     // foreach ($current[0] as $key => $value) {
        //     //    dd($key .' '. $value);
        //     // }
        //    dd((new BSONDocument)->bsonUnserialize($current));
        //    dd((($current)));


        // $unreadMessageCount = User::raw(function($collection)
        // {
        //     return $collection->aggregate([
        //     [
        //     '$match' => [
        //         'to_id' => auth()->id()
        //     ]
        //     ],
        //         [
        //             '$group' => [
        //                 '_id' => '$from_id',
        //                 'messages_count' => [
        //                     '$sum' => 1
        //                 ]
        //             ]
        //         ]
        //     ]);
        // });




        // $tags = self::raw(function ($collection) use ($query) {
        //     return $collection->aggregate($query);
        // });

        dd($this->formatBSON($usera->toArray()[0]));

        // dd($usera->toArray() );
        // foreach ($usera->toArray()[0] as $k => $item) {
        //     // dd($item);

        //         dd($this->formatTypeBson($item));

        // }

    }



    public function formatBSON($data)
    {
        $response = null;
         {
            foreach ($data as $key => $value) {

                 $response = $this->formatTypeBson($value);
                if (is_array($response)) {
                    foreach ($response as $k => $val) {
                        // dd($response[$k]);
                        $response[$k] = dd($this->formatBSON($val));
                    }
                }
            }
        }
        return $response;
    }

    function formatTypeBson($item)
    {
        // Debugbar::info($item);

        // dd((get_class($item) ));
        $response = $item;
        if (isset($item) && gettype($item) == "object" && (get_class($item) == "MongoDB\Model\BSONArray" || get_class($item) == "MongoDB\Model\BSONDocument")) {

            $bsonSerialize = $item->bsonSerialize();
            $response = array_values((array)$bsonSerialize);

            // dd($response);


        } else if (isset($item) && gettype($item) == "object" && get_class($item) == "MongoDB\BSON\UTCDateTime") {

            $response = $item->toDateTime();
        }

        return $response;
    }

    /**
     * Serialize collection.
     *
     * @param  mixed $collection
     * @return mixed|null
     */
    protected function serialize($collection)
    {
        return $collection instanceof Arrayable ? $collection->toArray() : (array) $collection;
    }
}
