<?php

use App\Models\Photo;
use App\Models\Product;
use App\Models\Staff;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/insertStaff/{name}', function($name){
    return Staff::create(['name'=>$name]);
});

Route::get('/insertProduct/{product}', function($product){
    return Product::create(['name'=>$product]);
});

//insert staff photos
Route::get('insertStaffPhoto/{staffId}/{staffImg}', function($staffId,$staffImg){
    $staff = Staff::findOrFail($staffId);
    return $staff->photos()->create(['path'=>$staffImg]);
});

//insert product photos (chocolate, ice-cream and cookie)
Route::get('insertProductPhoto/{productId}/{productImg}', function($productId, $productImg){
    $product = Product::findOrFail($productId);
    $product->photos()->create(['path'=>$productImg.'.jpg']);
});

//read staff photos
Route::get('readStaffPhotos/{staffId}', function($staffId){
    $staff = Staff::findOrFail($staffId);
    foreach($staff->photos as $photo){
        echo $photo->path.'<br />';
    }
});

//read product photos
Route::get('readProductPhotos/{productId}', function($productId){
    $product = Product::findOrFail($productId);
    foreach($product->photos as $photo){
        echo $photo->path.'<br />';
    }
});

//updating staff photos
Route::get('updateStaffPhotos/{staffId}', function($staffId){
    $staff = Staff::findOrFail($staffId);
    $photo = $staff->photos()->whereId(1)->first();
    $photo->path = 'newTsu.jpg';
    $photo->save();
});

//updating product photos
Route::get('updateProductPhotos/{productId}/{photoId}/{newProduct}', function($productId, $photoId, $newProduct){
    $product = Product::findOrFail($productId);
    $photo = $product->photos()->whereId($photoId)->first();
    $photo->path = $newProduct;
    $photo->save();
});


//delete staff photos
Route::get('deleteStaffPhoto/{staffId}/{photoId}', function($staffId, $photoId){
    $staff = Staff::findOrFail($staffId);
    $staff->photos()->whereId($photoId)->delete();
});

//delete product photo
Route::get('deleteProductPhoto/{productId}/{photoId}', function($productId, $photoId){
    $product = Product::findOrFail($productId);
    $product->photos()->whereId($photoId)->delete();
});

//assign staff photo
Route::get('assignStaffPhoto/{staffId}/{photoId}', function($staffId,$photoId){
    $staff = Staff::findOrFail($staffId);
    $photo = Photo::findOrfail($photoId);
    $staff->photos()->save($photo);
});
