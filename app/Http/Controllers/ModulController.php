<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Moduller;
use App\Models\Kategoriler;
use File;

class ModulController extends Controller
{
    function __construct()
    {
       view()->share('moduller',Moduller::whereDurum(1)->get());
    }
    public function index()
    {
        return view("admin.include.moduller");
    }
    public function modulekle(Request $request)
    {
    $request->validate([
        "baslik"=>'required|string',
    ]);
    $baslik=$request->baslik;
    $selflink=Str::of($baslik)->slug('');
    $kontrol=Moduller::whereSelflink($selflink)->first();
    if($kontrol)
    {
        return redirect()->route('moduller')->with('hata','Bu Modul Daha önce Eklenmiştir.');
    }
    else
    {
        /* 1. Adım Modül oluşturma işlemi.*/
        Moduller::create([
            "baslik"=>$baslik,
            "selflink"=>$selflink
        ]);
        /* 2. Adım Kategori Kayıt işlemi */
        Kategoriler::create([
            "baslik"=>$baslik,
            "selflink"=>$selflink,
            "tablo"=>"modul",
            "sirano"=>1
        ]);

        /*3. Adım Dinamik Tablo oluşturma işlemi*/

        Schema::create($selflink, function (Blueprint $table) {
            $table->id();
            $table->string('baslik',255);
            $table->string('selflink',255);
            $table->string('resim',255)->nullable();
            $table->longText('metin')->nullable();
            $table->unsignedBigInteger('kategori')->nullable();
            $table->string('anahtar',255)->nullable();
            $table->string('description',255)->nullable();
            $table->enum('durum',[1,2])->default(1);
            $table->integer('sirano')->nullable();
            $table->timestamps();
            $table->foreign('kategori')->references('id')->on('kategoriler')->onDelete('cascade');
        });

        /*4.Adım Model Oluşturma */


        $modelDosyasi='<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class '.ucfirst($selflink).' extends Model
{
    use HasFactory;
    protected $table="'.$selflink.'";
    protected $fillable=["id","baslik","selflink","kategori","resim","metin","anahtar","description","durum","sirano","created_at","updated_at"];
}';

        File::put(app_path('Models')."/".ucfirst($selflink).'.php',$modelDosyasi);
        return redirect()->route('moduller')->with('basarili','İşleminiz Başarılı ile Kayıt Edildi.');
    }


    }
}
