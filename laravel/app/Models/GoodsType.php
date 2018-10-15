<?php
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class GoodsTypeModel extends Model
{
    /**
     * 获取博客文章的评论
     */
    public function comments()
    {
         return $this->hasMany('App\Comment');
    }
}