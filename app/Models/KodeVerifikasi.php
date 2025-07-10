<?
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeVerifikasi extends Model
{
    protected $table = 'kode_verifikasi';

    protected $fillable = ['kode', 'expires_at'];

    public $timestamps = true;
}
