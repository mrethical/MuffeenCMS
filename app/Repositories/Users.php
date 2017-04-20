<?php

 namespace App\Repositories;

 use App\Models\User;
 use DB;

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

     public static function getCount()
     {
         if (auth()->user()->type == 'superadmin') {
             return User::count();
         } else {
             return User::where('type', '!=' , 'superadmin')
                 ->count();
         }
     }

     public static function getLatestOnLastThirtyDaysWithLimit($limit)
     {
         if (auth()->user()->type == 'superadmin') {
             return User::where(DB::raw("DATEDIFF(NOW(), 'created_at')", '<=', 30))
                 ->limit($limit)
                 ->get();
         } else {
             return User::where(DB::raw("DATEDIFF(NOW(), 'created_at')", '<=', 30))
                 ->where('type', '!=' , 'superadmin')
                 ->limit($limit)
                 ->get();
         }
     }

 }