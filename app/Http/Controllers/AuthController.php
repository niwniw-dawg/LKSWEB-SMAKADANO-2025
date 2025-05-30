<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    public function index(){
       // kita ambil data user lalu simpan pada variable $user
        $user = Auth::user();
        // kondisi jika user nya ada 
        if($user){
            // jika user nya memiliki level admin
            if($user->level =='1'){
                 // arahkan ke halaman admin ya :P
                return redirect()->intended('admin');
            }
            // jika user nya memiliki level pengembang
            if($user->level =='1'){
                // arahkan ke halaman pengembang ya :P
                return redirect()->intended('dev');
            }
           
              // jika user nya memiliki level user
            else if($user->level =='3'){
               // arahkan ke halaman user
                return redirect()->intended('user');
            }

        }
        return view('login');
     }
    //
    public function proses_login(Request $request){
      // kita buat validasi pada saat tombol login di klik
      // validas nya username & password wajib di isi 
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);
    
       
       // ambil data request username & password saja 
        $credential = $request->only('username','password');

      // cek jika data username dan password valid (sesuai) dengan data
        if(Auth::attempt($credential)){
           // kalau berhasil simpan data user ya di variabel $user
            $user =  Auth::user();
            // cek lagi jika level user admin maka arahkan ke halaman admin
            if($user->level =='admin'){
                return redirect()->intended('admin');

            }
                // tapi jika level user nya user biasa maka arahkan ke halaman user
               else if($user->level =='user'){
                return redirect()->intended('user');
            }
             // jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }

// jika ga ada data user yang valid maka kembalikan lagi ke halaman login
// pastikan kirim pesan error juga kalau login gagal ya
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal'=>'These credentials does not match our records']);



     }

     public function register(){
      // tampilkan view register
        return view('register');
      }


// aksi form register
      public function proses_register(Request $request){ 
//. kita buat validasi nih buat proses register
 // validasinya yaitu semua field wajib di isi
// validasi username itu harus unique atau tidak boleh duplicate username ya
        $validator =  Validator::make($request->all(),[
            'name'=>'required',
            'username'=>'required|unique:users',
            'email'=>'required|email',
            'password'=>'required'
        ]);
        
// kalau gagal kembali ke halaman register dengan munculkan pesan error
        if($validator ->fails()){
            return redirect('/register')
             ->withErrors($validator)
             ->withInput();
        }
// kalau berhasil isi level & hash passwordnya ya biar secure
        $request['level']='user';
        $request['password'] = bcrypt($request->password);

// masukkan semua data pada request ke table user
        User::create($request->all());

         // kalo berhasil arahkan ke halaman login
        return redirect()->route('login');
      }

     public function logout(Request $request){
// logout itu harus menghapus session nya 

        $request->session()->flush();

// jalan kan juga fungsi logout pada auth 

        Auth::logout();
// kembali kan ke halaman login
        return Redirect('login');
      }
}