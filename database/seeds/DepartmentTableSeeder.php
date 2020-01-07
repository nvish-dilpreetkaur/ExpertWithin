<?php

use Illuminate\Database\Seeder;
use App\Models\Department;
class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Department::create(
			array('dept_name' => 'IT','color_code'=>'#0179F1','status'=>'1')
		);
		Department::create(
			array('dept_name' => 'HR','color_code'=>'#645AB7','status'=>'1')
		);
		Department::create(			
			array('dept_name' => 'Facilities','color_code'=>'#8A3E16','status'=>'1')
		);
		Department::create(			
			array('dept_name' => 'Sales & Marketing','color_code'=>'#F1A702','status'=>'1')
		);
		Department::create(			
			array('dept_name' => 'Operations','color_code'=>'#ff0476','status'=>'1')
		);
		Department::create(			
			array('dept_name' => 'Finance & Purchasing','color_code'=>'#6A884B','status'=>'1')
		);
		Department::create(			
			array('dept_name' => 'Creative','color_code'=>'#02D5F1','status'=>'1')
		);
    }
}
