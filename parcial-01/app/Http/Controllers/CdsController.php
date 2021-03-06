<?php

namespace App\Http\Controllers;


use App\Models\Artist;
use App\Models\Cart;
use App\Models\Cd;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CdsController extends Controller
{
    public function index(Request $request){


        $formParams = [];
        $userRol = 0;

        $cdsQuery = Cd::with('artist', 'genres');

        if($request -> query('cdtitle')){
            $cdsQuery->where('title', 'like', '%' . $request -> query('cdtitle') . '%');
            $formParams['cdtitle'] = $request -> query('cdtitle');
        }

        $cds = $cdsQuery->paginate(3)->withQueryString();

        if(Auth::user() != null){
            $userRol = Auth::user()->rol;
        }

        return view('cds.index', compact('cds', 'formParams', 'userRol'));
    }

    public function view(Cd $cd){

        $userRol = 0;

        if(Auth::user() != null){
            $userRol = Auth::user()->rol;
        }

        return view('cds.view', compact('cd', 'userRol'));
    }

    public function newForm(){
        
        $artists = Artist::all();
        $genres = Genre::all();

        return view('cds.new', compact('artists', 'genres'));
    }

    public function create(Request $request){


        $request->validate(Artist::$rules);
        

        $request->validate(Cd::$rules);
        
        $cd = Cd::create($request->only(['title','description','duration','cost','release_date', 'artist_id', 'genre_id']));

        $cd->genres()->attach($request->input('genre_id'));

        return redirect()
        ->route('cds.index')
        ->with('message', 'CD created successful')
        ->with('message-type', 'success');
    }

    public function editForm(Cd $cd){

        $artists = Artist::all();
        $genres = Genre::all();
        
        //dd($rol);

        return view('cds.edit', compact('cd', 'artists', 'genres'));
    }

    public function edit(Request $request, Cd $cd){

        $request->validate(Cd::$rules);
        $cd->update($request->only(['title','description','duration','cost','release_date', 'artist_id']));
        
        $cd->genres()->sync($request->input('genre_id'));

        return redirect()
        ->route('cds.index')
        ->with('message', 'CD updated successful')
        ->with('message-type', 'success');
    }
    
    public function delete(Cd $cd){

        $cd->genres()->detach();
        $cd->delete();

        Cart::where('cd_id', $cd->cd_id)
        ->delete();

        return redirect()
        ->route('cds.index')
        ->with('message', 'CD deleted successful')
        ->with('message-type', 'success');
    }
}
