<?php

namespace App\Models\Traits;

Trait QueryBuilderBindable
{
    public function resolveRouteBinding($value)
    {
        // 如果模型里定义了 queryClass，就用模型里指定的 queryClass 类
        // 否则用模型对应的 app/Http/Queries/xxxQuery
        $queryClass = property_exists($this, 'queryClass')
            ? $this->queryClass
            : '\\App\\Http\\Queries\\' . class_basename(self::class) . 'Query';

        // 如果两者都不存在，用父类原本的
        if (!class_exists($queryClass)) {
            return parent::resolveRouteBinding($value);
        }

        return (new $queryClass($this))
            ->where($this->getRouteKeyName(), $value)
            ->first();
    }
}


// 捋一捋，
// 第一层封装：封装了 QueryBuilder，app/Http/Queries/TopicQuery.php
// 把可能需要加载的关联和查询的字段封装起来了
// 在各个要查询的控制器里都能使用
// 第二层封装：封装了 QueryBuilderBindable，app/Models/Traits/QueryBuilderBindable.php
// 重写了 resolveRouteBinding，这个方法是用来自动查找模型的
// 原来是直接找，重写后先加载了 QueryBuilder
