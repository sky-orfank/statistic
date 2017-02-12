<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i=1; $i<=10; $i++) {
	        DB::table('pages')->insert([
	            'title' => 'page #'.$i,
	            'text' => 'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i.'. '.'Text page #'.$i
	        ]);
    	}
    }
}
