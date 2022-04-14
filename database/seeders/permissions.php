<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = ['audiences','users','roles','settings','announcements','files','courses','coupons','category','orders','languages','public-alerts','reports','certificates','search','suport-conversition','logs','statistics'];
        $b = ['browse','edit','delete','add','view'];
        $c =['access dashboard'];

        foreach ($a as $Aval) {
            foreach ($b as $Bval) {
                Permission::create([
                    'name' => $Bval .' '. $Aval,
                    'code' => $Bval .'-'. $Aval,
                    'group' => $Aval
                ]);
            }
        }
        foreach ($c as $Cval) {
            Permission::create([
                'name' => $Cval,
                'code' => str_replace(' ','-' ,$Cval) ,
                'group' => 'general'
            ]);
        }
    }
}
