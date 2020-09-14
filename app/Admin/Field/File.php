<?php

namespace App\Admin\Field;

class File extends Field
{

   public function type()
   {
       return 'file';
   }

   public function enableDefault()
   {
       return ['create', 'update'];
   }

}
