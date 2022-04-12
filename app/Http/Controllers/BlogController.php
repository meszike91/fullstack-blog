<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request){
        $categories = Category::select('id', 'categoryName')->get();
        $blogs = Blog::orderBy('id', 'desc')->with(['user', 'categories'])->limit(6)->get(['id','title','post_excerpt', 'slug', 'user_id','featuredImage']);
        return view('home')->with(['blogs' => $blogs, 'categories' => $categories]);
    }
    public function blogSingle(Request $request, $slug){
        $blog = Blog::where('slug', $slug)->with(['categories', 'tags', 'user'])->first(['id', 'title', 'post_excerpt', 'user_id', 'featuredImage', 'post', 'created_at']);
        return view('blogsingle')->with(['blog'=> $blog]);
    }
    public function compose(View $view){
        $view->with('categories', Category::select('id', 'categoryName')->get());
    }
}
