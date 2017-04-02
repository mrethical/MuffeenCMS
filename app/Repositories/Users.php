<?php

 namespace App\Repositories;

 use App\Models\User;

 class Users
 {

     public static function getAllPermittedWithLimit($limit, $offset = 0)
     {
         if (auth()->user()->type == 'superadmin') {
             return User::select(['id', 'name', 'type', 'email'])
                 ->take($limit)
                 ->offset($offset)
                 ->get();
         } else if (auth()->user()->type == 'admin') {
             return User::select(['id', 'name', 'type', 'email'])
                 ->where('type', '!=' , 'superadmin')
                 ->take($limit)
                 ->offset($offset)
                 ->get();
         } else {
             return [];
         }
     }

     public static function getCountPermitted()
     {
         if (auth()->user()->type == 'superadmin') {
             return User::count();
         } else if (auth()->user()->type == 'admin') {
             return User::where('type', '!=' , 'superadmin')
                 ->count();
         } else {
             return 0;
         }
     }

 }