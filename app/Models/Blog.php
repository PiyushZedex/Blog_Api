<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Blog extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'blogs';

//    protected $fillable = [
//       'user_id', 'title', 'body'
//    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',

    ];

    /**
     * @var mixed
     */


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function categories ()
    {
        return $this->belongsToMany(Category::class, 'categorymapper', 'blog_id', 'category_id');
    }



}
