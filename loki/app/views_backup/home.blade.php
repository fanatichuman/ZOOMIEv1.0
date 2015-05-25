@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Pictures</h1>
            <h2>Total excluding doubles: {{$g->getTotal()}}</h2>
            <table class="table table-striped">
                <thead> <tr> <th>#</th> <th>Pictures</th> </tr> </thead>
                <tbody>
                @foreach($g as $group)
                <tr data-group-id="{{$group->id}}" id="group-{{$group->id}}">
                  <td>{{$group->id}}</td>
                    <td class="droppable">
                    <ul class="connectedSortable list-inline">
                    @foreach($group->pictures as $picture)
                    <li class="draggable" data-group-id="{{$group->id}}">
                    <img src="/pictures/{{ $picture->Image }}" alt="" 
                        class="phyto"
                        data-toggle="popover"
                        data-placement="top"
                        data-content="<ul class='list-unstyled'>
                            <li>Area: {{$picture->Area}}</li>
                            <li>Pos X: {{$picture->posx}}</li>
                            <li>Pos Y: {{$picture->posy}}</li>
                            <li>Timestamp: {{$picture->Date . ' milli: '. $picture->milliseconds}}</li>
                        </ul>"
                        data-title="{{$picture->Image}}"
                        data-id="{{$picture->id}}"
                    />
                    <a href="#" class="btn btn-default btn-xs new-group">New group</a>
                    <a href="#" class="btn btn-danger btn-xs delete-guy">Delete</a>
                    </li>
                    @endforeach
                    </ul>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{$g->links()}}
        </div>
    </div>
</div>
@stop
