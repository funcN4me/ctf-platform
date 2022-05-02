<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task = Task::create(['name' => 'CSRF ZERO PROTECTION', 'category_id' => 1, 'subcategory' => 'CSRF',
            'description' => 'Данный сервис уязвим к CSRF атакам, попробуйте найти и эксплуатировать уязвимость',
            'flag' => '4hsl33p{CsRF_Z3r0_pR07ec7ioN}']);
        $resource = Resource::create(['category_id' => 1,'title' => 'CSRF что это?']);
        $resource->save();

        $task->resources()->attach($resource);
        $task->save();

        $task = Task::create(['name' => 'crackme', 'category_id' => 2, 'subcategory' => 'Buffer overflow',
            'description' => 'Данный бинарный файл уязвим к переполнению буффера, переполните и получите флаг',
            'flag' => '4hsl33p{8ufFeR_0v3rflow}']);
        $resource = Resource::create(['category_id' => 2, 'title' => 'Buffer overflow?']);
        $resource->save();

        $task->resources()->attach($resource);
        $task->save();

        $task = Task::create(['name' => 'HTML - комментарии', 'category_id' => 1, 'subcategory' => 'HTML',
            'description' => 'Довольно часто бывает так, что при разработке программисты оставляют комментарии в коде. Эти комментарии могут быть совсем безобидными, например, они могут говорить о том, что закончился тот или иной блок, но иногда комментарии могут содержать какую-то полезную информацию для человека со стороны...',
            'url' => 'http://tasks/task_html.html',
            'flag' => '4hsl33p{H7Ml_C0mMent5}']);
        $resource = Resource::create(['category_id' => 1, 'title' => 'HTML']);
        $resource->save();

        $task->resources()->attach($resource);
        $task->save();
    }
}
