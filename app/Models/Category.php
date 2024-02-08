<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Category extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'categories';

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
        'pivot',
    ];

    /**
     * @var mixed
     */


    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'categorymapper', 'category_id', 'blog_id');
    }





}
