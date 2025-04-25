# Gem Desk

## Contributing
Please refer to each project's style and contribution guidelines for submitting patches and additions. In general, we follow the "clone-and-pull" Git workflow.
1. **Clone** the project to your own machine
```
git clone git@github.com:TubesWAD/gem-desk.git
```
2. **Commit** changes to your own branch
```
git add . 
git commit -m"your commit message"
```
3. **Push** your work back up to your branch
```
git push origin your-branch
```
4. Submit a **Merge Request** so that anyone can review your changes

NOTE: Be sure to merge the latest from "upstream" before making a merge request!

## Getting started

### Requirements
- php version >= 8.1

## Usage

### Config

Clone config file `env.example`, put it on the same directory and rename it to `.env`

## Step by Step Contributing
### Make Migrations
Create migration using
```
php artisan make:migrations your_table_name
```
example migration file
```
public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    
public function down(): void
    {
        Schema::dropIfExists('users');
    }
```
after that migrate it using
```
php artisan migrate
```

### Make Controller 
Create Controller while create resource and model using
```
php artisan make:controller YourControllerName --resource --model=ModelName
```
if you're running with this command, there will be several function in controller 
1. index
```
    public function index(Request $request)
        {

            $query  =  $request->get('query');
            if($request->ajax()){
                $data = Ticket::query()->where('title', 'LIKE', $query . '%')
                    ->limit(10)
                    ->get();
                $output = '';
                if (count($data) > 0){
                    foreach ($data as $index => $row){
                        $output .= '
                                    <tr>
                                        <td>' . $index + $data->firstItem() . '</td>
                                        <td>' . $row->title . '</td>
                                        <td>' . $row->description . '</td>
                                        <td>' . $row->ticket_type . '</td>
                                        <td>' . $row->status . '</td>
                                        <td class="d-flex justify-content-center">
                                            <a class="btn btn-success me-1" href="' . route('tickets.show', $row->id) . '">Show</a>
                                            <a class="btn btn-primary me-1" href="' . route('tickets.edit', $row->id) . '">Edit</a>
                                            <form action="' . route('tickets.destroy', $row->id) . '" method="post">
                                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger me-1">Delete</button>
                                            </form>
                                        </td>
                                        </tr>
                                    ';
                    }
                }else{
                    $output .= '<td colspan="6">
                            <div class="d-flex justify-content-center">
                                No Record Found
                            </div>
                        </td>';
                }
                return $output;
            }


            $tickets = Ticket::query()->where('title', 'LIKE', '%' . $query . '%')
                ->simplePaginate(8);
            return view('tickets.index', compact('tickets'));
        }

```
2. create
```
    return response(view('tickets.create'));
```
3. store
```
 public function store(StoreTicketRequest $request): RedirectResponse
    {
        $ticket = new Ticket;
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        if ($request->hasFile('file')){
            $pathFile = $request->file('file')->store('files', 'public');
            $ticket->files = $pathFile;
        }else{
            $ticket->files = '';
        }
        $ticket->status = "open";
        $ticket->is_resolved = 0;
        $ticket->ticket_type = $request->ticket_type;

        $ticket->save($request->validated());
        return redirect(route('tickets.index'));
    }
```
4. show
```
public function show(Ticket $ticket): View
    {
        return view('tickets.show', compact('ticket'));
    }
```
5. edit
```
public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', compact('ticket'));
    }
```
6. update
```
public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        if ($request->hasFile('files')) {
            if ($oldFile = $ticket->files) {
                unlink(storage_path('app/files/') . $oldFile);
            }
            $pathFile = $request->file('file')->store('files', 'public');
            $ticket->files = $pathFile;
        }
        $ticket->ticket_type = $request->ticket_type;

        $ticket->update($request->validated());

        return redirect(route('tickets.index'))->with('success', 'Ticket updated successfully');

    }
```
7. destroy
```
public function destroy(Ticket $ticket): RedirectResponse
    {
        $oldFile = $ticket->files;
        unlink(storage_path('app/public/') . $oldFile);
        $ticket->delete();

        return redirect(route('tickets.index'))->with('error', 'Sorry, unable to delete this!');
    }
```

The example given is case for Ticket, you must be adjust with your purpose

### Make View
Create view using, if your are make a master data there must be 4 file
1. create
2. edit
3. index
4. show
```
php artisan make:view yourfolder.namefile
```
so we will be implementing the extends and section ways, we have layouts.app for the base view
we should extends from that by using ``` @extends('layouts.app') ``` and then ``` @section('content')``` for where we build our features.

this file should be like this

```
@extends('layouts.app')

@section('content')
~~~~
~~~
~~

@endsection
```

### Running Laravel
running laravel using
```
php artisan serve
```




