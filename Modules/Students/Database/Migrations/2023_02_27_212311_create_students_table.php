<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
   /**
     *所需命令行   php artisan module:make DistributionApi
     *1.创建迁移文件：php artisan module:make-migration  create_auths_table Admin
     *php artisan make:migration add_images_to_articles_table --table=articles
     *2.执行迁移文件：php artisan module:migrate Admin
     *3.修改表字段：php artisan module:make-migration update_moments_table
     *4.重新执行迁移文件：php artisan module:migrate-refresh Admin
     *5.创建数据填充文件：php artisan module:make-seed  auths_table_seeder AuthAdmin
     *6.执行数据填充文件：php artisan module:seed AuthAdmin
     */
    public function up()
    {
        /**
         * 学生表
         */
        Schema::create('students', function (Blueprint $table) {
            $table->comment = '学生表';
            $table->increments('id')->comment('学生ID');
            $table->string('name',100)->default('')->comment('学生姓名');
            $table->string('phone',100)->default('')->comment('手机号');
            $table->string('stdid',50)->unique()->default('')->comment('学号');
            $table->string('password')->default('')->comment('密码');
            $table->string('class_id')->default('')->comment('班级ID');
            $table->string('grade_id')->default('')->comment('年级ID');
            $table->integer('group_id')->nullable()->comment('权限组ID');
            $table->integer('project_id')->nullable()->comment('项目ID');
            $table->tinyInteger('status')->default(1)->comment('状态:0=禁用,1=启用');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
