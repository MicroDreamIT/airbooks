<?php

use App\Aircraft;
use App\Category;
use App\Manufacturer;
use App\Modeled;
use App\Type;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AircraftSeeders extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();
        $lastId = Aircraft::latest()->first();

        foreach (range(1, 20) as $index){
            if (!$lastId) {
                $uid = 'ABA'.'01';
            }else{
                $uid = 'ABA'. ($lastId->id + 1);
            }

            $data=[

            ];

            $aircraft=new Aircraft($data);
            $aircraft->user()->associate(auth()->id());
            $aircraft->category()->associate(random(1, Category::where('type', 'aircraft')->lists('id')->random(1)));
            $aircraft->manufacturer()->associate($this->input('aircraftManufacturer')['id']);
            $aircraft->type()->associate($this->input('aircraftType')['id']);
            $aircraft->modeled()->associate($this->input('aircraftModel')['id']);
            $aircraft->engineManufacturer()->associate($this->input('engineManufacturer')['id']);
            $aircraft->engineType()->associate($this->input('engineType')['id']);
            $aircraft->engineModel()->associate($this->input('engineModel')['id']);
            foreach ($this->input('custom2') as $custom){
                $custom['name']=='owner'?$aircraft->owner()->associate($custom['value']['id']):null;
                $custom['name']=='current_operator'?$aircraft->currentOperator()->associate($custom['value']['id']):null;
                $custom['name']=='previous_operator'?$aircraft->previousOperator()->associate($custom['value']['id']):null;
                $custom['name']=='manager'?$aircraft->manager()->associate($custom['value']['id']):null;
                $custom['name']=='seller'?$aircraft->seller()->associate($custom['value']['id']):null;
            }

            foreach ($this->input('custom') as $custom){
                $custom['name']=='registration_number'?$aircraft->registration_number=$custom['value']:null;
                $custom['name']=='registration_country'?$aircraft->registeredIn()->associate($custom['value']['id']):null;
                $custom['name']=='tsn'?$aircraft->tsn=$custom['value']:null;
                $custom['name']=='csn'?$aircraft->csn=$custom['value']:null;
                $custom['name']=='mtow'?$aircraft->mtow=$custom['value']:null;
                $custom['name']=='mlgw'?$aircraft->mlgw=$custom['value']:null;
                $custom['name']=='last_c_check'?$aircraft->last_c_check=Carbon::parse($custom['value']):null;
                $custom['name']=='complience'?$aircraft->complience=$custom['value']:null;
            }

            $aircraft->configuration()->associate($this->input('configuration')['id']);

            $aircraft->currentLocation()->associate($this->input('current_location')['id']);

            $aircraft->primaryContact()->associate($this->input('primary_contact')['id']);
            $aircraft->YOM = Carbon::parse($this->input('YOM'));
            $aircraft->availability = Carbon::parse($this->input('availability'));
            if($this->input('aircraftModel')){
                $aircraft->title = Carbon::parse($this->input('YOM'))->year .'-'. str_replace(' ', '-',$this->input('aircraftManufacturer')['name']) .'-' . str_replace(' ','-',$this->input('aircraftModel')['name']) .'-for-'. $this->input('offer_for');
            }else{
                $aircraft->title = Carbon::parse($this->input('YOM'))->year .'-'. str_replace(' ', '-',$this->input('aircraftManufacturer')['name']) .'-for-'. $this->input('offer_for');
            }

            $aircraft->uid = $uid;
            $aircraft->save();

            if(count($this->input('images'))>0){
                foreach ($this->input('images') as $image){
                    $aircraft->medias()->create([
                        'type'=>$image['type'],
                        'path'=>$image['path'],
                        'original_file_name'=>$image['original_file_name'],
                        'is_featured'=>array_key_exists('is_featured', $image)? $image['is_featured']: false
                    ]);
                }
            }
        }

    }
}
