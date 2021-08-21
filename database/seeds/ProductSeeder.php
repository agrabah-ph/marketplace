<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Unit;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = array(
            'Rice',
            'Pig',
            'Cattle',
            'Cows milk',
            'Chicken',
            'Maize (Corn)',
            'Wheat',
            'Soybeans',
            'Eggs',
            'Potatoes',
            'Vegetables',
            'Tomatoes',
            'Sugarcane',
            'Grapes',
            'Seed Cotton',
            'Buffalo milk',
            'Cotton lint',
            'Apples',
            'Onions',
            'Sheep',
            'Cucumbers and Gherkins',
            'Garlic',
            'Bananas',
            'Goat',
            'Oil palm fruit',
            'Cassava (yuca)',
            'Palm oil',
            'Watermelons',
            'Rapeseed',
            'Mangos',
            'Mangosteens',
            'Guavas',
            'Eggs',
            'Groundnuts',
            'Chilis and peppers',
            'Sweet Potatoes',
            'Barley',
            'Oranges',
            'Eggplants (aubergines)',
            'Olives',
            'Sunflower seeds',
            'Tangerines',
            'Mandarins',
            'Clementines',
            'Satsumas',
            'Cabbages and other brassicas',
            'Spinach',
            'Strawberries',
            'Peaches',
            'nectarines',
            'Tobacco',
            'Coffee',
            'Lettuce',
            'Rubber',
            'Tea',
            'Peas'
        );

        $units = array(
            array(
                array('kilogram', 'kg'),
                array('gram', 'g'),
                array('milligram', 'mg')
            ),
            array(
                array('gallon', 'g'),
                array('liter', 'ltr'),
                array('ounce', 'oz')
            ),
            array(
                array('meter', 'm'),
                array('feet', 'ft'),
                array('millimeter', 'mm'),
                array('centimeter', 'cm'),
                array('inch', 'in')
            )
        );

        foreach ($lists as $list){
            $data = new Product();
            $data->name = stringSlug($list);
            $data->display_name = $list;
            if($data->save()){
                $unitsData = $units[rand(0,2)];
                foreach ($unitsData as $unitData){
                    $unit = new Unit();
                    $unit->name = $unitData[0];
                    $unit->abbr = $unitData[1];
                    $data->units()->save($unit);
                }
            }
        }
    }
}
