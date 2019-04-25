<?php
/**
 * Menu Status
 */
Route::patch('menu-status/{id}', 'MenuController@status')->name('menu-status');
/**
 * Menu Crud
 */
Route::resource('menu', 'MenuController');
/**
 * Menu itens
 */
Route::patch('menu-item-order', 'MenuItemController@reOrder')->name('menu-item-order');

Route::resource('menu-items', 'MenuItemController');