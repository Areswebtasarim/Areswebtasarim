<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moduller;
use App\Models\Kategoriler;
use Illuminate\Support\Str;
use App\Models\Ayarlar;
use App\Models\Iletisim;
use RealRashid\SweetAlert\Facades\Alert;

class AdminYonetim extends Controller
{
    function __construct()
    {
        view()->share('moduller',Moduller::whereDurum(1)->get());
    }
    public function home()
    {
        return view('admin.include.home');
    }
    public function liste($modul)
    {
        $dinamikModul=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        if($dinamikModul)
        {
            $dinamikModel="App\Models\\".ucfirst($dinamikModul->selflink);
            $veriler=$dinamikModel::get();
            return view('admin.include.liste',compact(['veriler','dinamikModul']));
        }
        else {
            return redirect()->route('home');
        }
    }

    public function ekle($modul)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        $kategoriBilgisi=Kategoriler::whereTablo('modul')->whereSelflink($modul)->get();
        if($modulBilgisi && $kategoriBilgisi)
        {
            return view('admin.include.ekle',compact(['modulBilgisi','kategoriBilgisi']));

        }
        else {
            return redirect()->route('home');
        }
    }
    public function eklePost($modul,Request $request)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        if($modulBilgisi)
        {
        $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
        $request->validate([
            "baslik"=>'required',
            "kategori"=>'required',
            "anahtar"=>'required',
            "description"=>'required',
        ]);
        $baslik=$request->baslik;
        $selflink=Str::of($baslik)->slug('');
        $metin=$request->metin;
        $kategori=$request->kategori;
        $anahtar=$request->anahtar;
        $description=$request->description;
        $sirano=$request->sirano;
        $dinamikModel="App\Models\\".$modelDosyaAdi;
        $resimDosyasi=$request->file('resim');
        if(isset($resimDosyasi))
        {
            $resim=uniqid().".".$resimDosyasi->getClientOriginalExtension();
            $resimDosyasi->move(public_path("images/".$modulBilgisi->selflink),$resim);
            $kaydet=$dinamikModel::create([
                "baslik"=>$baslik,
                "selflink"=>$selflink,
                "metin"=>$metin,
                "kategori"=>$kategori,
                "resim"=>$resim,
                "anahtar"=>$anahtar,
                "description"=>$description,
                "sirano"=>$sirano
            ]);
        }
        else{
            $kaydet=$dinamikModel::create([
                "baslik"=>$baslik,
                "selflink"=>$selflink,
                "metin"=>$metin,
                "kategori"=>$kategori,
                "anahtar"=>$anahtar,
                "description"=>$description,
                "sirano"=>$sirano
            ]);
        }

            return redirect()->route('ekle',$modulBilgisi->selflink)->with('success','İşleminiz Başarılı ile Kayıt Edildi.');
        }
        else{
            return redirect()->route('home');

        }
    }


    /*Duzenle Kısmı*/
    public function duzenle($modul,$id)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        $kategoriBilgisi=Kategoriler::whereTablo('modul')->whereSelflink($modul)->get();
        if($modulBilgisi && $kategoriBilgisi)
        {
            $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
            $dinamikModel="App\Models\\".$modelDosyaAdi;
            $veriler=$dinamikModel::whereId($id)->first();
            return view('admin.include.duzenle',compact(['modulBilgisi','kategoriBilgisi','veriler']));

        }
        else {
            return redirect()->route('home');
        }
    }
    public function duzenlePost($modul,$id,Request $request)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        if($modulBilgisi)
        {
            $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
            $request->validate([
                "baslik"=>'required',
                "kategori"=>'required',
                "anahtar"=>'required',
                "description"=>'required',
            ]);
            $baslik=$request->baslik;
            $selflink=Str::of($baslik)->slug('');
            $metin=$request->metin;
            $kategori=$request->kategori;
            $anahtar=$request->anahtar;
            $description=$request->description;
            $sirano=$request->sirano;
            $dinamikModel="App\Models\\".$modelDosyaAdi;
            $resimDosyasi=$request->file('resim');
            if(isset($resimDosyasi))
            {
                $resim=uniqid().".".$resimDosyasi->getClientOriginalExtension();
                $resimDosyasi->move(public_path("images/".$modulBilgisi->selflink),$resim);
                $kaydet=$dinamikModel::whereId($id)->update([
                    "baslik"=>$baslik,
                    "selflink"=>$selflink,
                    "metin"=>$metin,
                    "kategori"=>$kategori,
                    "resim"=>$resim,
                    "anahtar"=>$anahtar,
                    "description"=>$description,
                    "sirano"=>$sirano
                ]);
            }
            else{
                $kaydet=$dinamikModel::whereId($id)->update([
                    "baslik"=>$baslik,
                    "selflink"=>$selflink,
                    "metin"=>$metin,
                    "kategori"=>$kategori,
                    "anahtar"=>$anahtar,
                    "description"=>$description,
                    "sirano"=>$sirano
                ]);
            }

            return redirect()->route('duzenle',[$modulBilgisi->selflink,$id])->with('success','İşleminiz Başarılı ile Kayıt Edildi.');
        }
        else{
            return redirect()->route('home');

        }
    }
    /*Silme Kısmı*/
    public function sil($modul,$id)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
        $dinamikModel="App\Models\\".$modelDosyaAdi;
        $veriler=$dinamikModel::whereId($id)->first();
        if($modulBilgisi && $veriler)
        {
            $silme=$dinamikModel::whereId($id)->delete();
            return redirect()->route('liste',$modulBilgisi->selflink);

        }
        else {
            return redirect()->route('home');
        }
    }
    public function durum($modul,$id)
    {
        $modulBilgisi=Moduller::whereDurum(1)->whereSelflink($modul)->first();
        $kategoriBilgisi=Kategoriler::whereTablo('modul')->whereSelflink($modul)->get();
        if($modulBilgisi && $kategoriBilgisi)
        {
            $modelDosyaAdi=ucfirst($modulBilgisi->selflink);
            $dinamikModel="App\Models\\".$modelDosyaAdi;
            $veriler=$dinamikModel::whereId($id)->first();
            if($veriler)
            {
               if($veriler->durum==1){$durum=2;}else{$durum=1;}
                $kaydet=$dinamikModel::whereId($id)->update([
                    "durum"=>$durum,

                ]);
                return redirect()->back()->with('success','İşleminiz Başarıyla Kaydedildi.');

            }
                else{
                    return redirect()->back();
                }

        }
        else {
            return redirect()->back();
        }
    }
    public function ayarlar()
    {
        $veriler=Ayarlar::whereId(1)->first();
        return view('admin.include.ayarlar',compact('veriler'));

    }

    public function ayarpost(Request $request)
    {
        $request->validate([
            "title"=>'required|string',
            "keywords"=>'required|string',
            "description"=>'required|string',
        ]);

        $ilkgunceleleme=Ayarlar::whereId(1)->update([
            "title"=>$request->title,
            "keywords"=>$request->keywords,
            "description"=>$request->description,
            "bakimmodu"=>$request->bakimmodu
        ]);
        $logoDosyasi=$request->file('logo');
        if(isset($logoDosyasi))
        {
            $logo = "logo." . $logoDosyasi->getClientOriginalExtension();
            $logoDosyasi->move(public_path("images/"),$logo);
             $ikincigunceleleme=Ayarlar::whereId(1)->update([
                 "logo"=>$logo,

             ]);
        }
        $faviconDosyasi=$request->file('favicon');
        if(isset($faviconDosyasi))
        {
            $favicon ="favicon." .$faviconDosyasi->getClientOriginalExtension();
            $faviconDosyasi->move(public_path("images/"),$favicon);
             $ucuncugunceleleme=Ayarlar::whereId(1)->update([
                 "favicon"=>$favicon,

             ]);
        }
        return redirect()->route('ayarlar')->with('success','İşleminiz Başarılı ile Kayıt Edildi.');

    }
    /*iletisim Ayar*/
    public function iletisim()
    {
        $veriler=Iletisim::whereId(1)->first();
        return view('admin.include.iletisim',compact('veriler'));

    }

    public function iletisimpost(Request $request)
    {
        $request->validate([
            "tel"=>'required|string',
            "tel2"=>'required|string',
            "whatsapp"=>'required|string',
        ]);

        $iletisimguncelleme=Iletisim::whereId(1)->update([
            "tel"=>$request->tel,
            "tel2"=>$request->tel2,
            "whatsapp"=>$request->whatsapp,
            "adres"=>$request->adres,
            "googlemaps"=>$request->googlemaps,
            "email"=>$request->email
        ]);


        return redirect()->route('iletisim')->with('success','İşleminiz Başarılı ile Kayıt Edildi.');

    }
}
