<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  
    public function index()
    {
        $contacts = Contact::all();
        return view ('contact.index')->with('contacts', $contacts);
    }

    
    public function create()
    {
        return view('contact.create');
    }

   
    public function store(Request $request)
    {
        $name = filter_var($request->name, FILTER_DEFAULT);
        $email = filter_var($request->email, FILTER_VALIDATE_EMAIL);
        $address = filter_var($request->address, FILTER_DEFAULT);
        $mobile = filter_var($request->mobile, FILTER_DEFAULT);
        $cpf = filter_var($request->cpf, FILTER_DEFAULT);

        if(!$name || !$email || !$address || !$mobile  || !$cpf) {
            //dd("Preencha todos os campos");
            return redirect('contact')->with('error', 'Preencha todos os campos!');  
        }
        $input =  [
            "name" => $name,
            "email" => $email,
            "address" => $address, 
            "mobile" => $mobile,
            "cpf" => $cpf
        ];  
    
        Contact::create($input);

        //return  session()->flash('message', 'Post successfully updated.');
        return redirect('contact')->with('created', 'Contato criado com suceso!')->with("success", "success");  
    }

    
    public function show($id)
    {
        $contact = Contact::find($id);
        return view('contact.show')->with('contacts', $contact);
    }

    
    public function edit($id)
    {
        $contact = Contact::find($id);
        return view('contact.edit')->with('contacts', $contact);
    }

  
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $input = $request->all();
        $contact->update($input);
        return redirect('contact')->with('flash_message', 'Contact Updated!');  
    }

   
    public function destroy($id)
    {
        Contact::destroy($id);
        return redirect('contact')->with('flash_message', 'Contact deleted!');  
    }
}