@extends('layouts.app')

@section('scripts')

<link rel="stylesheet" href="{{ asset('fullcalendar/core/main.css')}}">
<link rel="stylesheet" href="{{ asset('fullcalendar/daygrid/main.css')}}">
<link rel="stylesheet" href="{{ asset('fullcalendar/list/main.css')}}">
<link rel="stylesheet" href="{{ asset('fullcalendar/timegrid/main.css')}}">

<script src="{{ asset('fullcalendar/core/main.js')}}" defer></script>

<script src="{{ asset('fullcalendar/interaction/main.js')}}" defer></script>

<script src="{{ asset('fullcalendar/daygrid/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/list/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/timegrid/main.js')}}" defer></script>

<script>

  document.addEventListener('DOMContentLoaded', function(){
    var calendarEl = document.getElementById('calendar');

    var  calendar = new FullCalendar.Calendar(calendarEl, {
      defaultDate: new Date(2019,8,1),
      plugins: ['dayGrid', 'interaction', 'timeGrid', 'list'],

      header:{
        left:'prev, next today Miboton',
        center:'title',
        right:'dayGridMonth, timeGridWeek, timeGridDay'
      },
      customButtons:{

        MiBoton:{
          text:"Botón",
          click:function(){

            alert("Hola Mundo!");
            $('#exampleModal').modal();
          }
        }

      },
      dateClick:function(info){
        $('#txtFecha').val(info.dateStr);
        $('#exampleModal').modal();
        console.log(info);
        calendar.addEvent({ title: "Evento X", date: info.dateStr });
      },
      eventClick:function(info){
        // console.log(info);
        // console.log(info.event.title);
        // console.log(info.event.start);
        //
        // console.log(info.event.end);
        // console.log(info.event.textColor);
        // console.log(info.event.backgroundColor);
        //
        // console.log(info.event.extendedProps.descripcion);

        $('#txtID').val(info.event.id);
        $('#txtTitulo').val(info.event.title);

        $('#txtFecha').val(info.event.start);
        $('#txtHora').val(info.event.start);
        $('#txtColor').val(info.event.backgroundColor);

        $('#txtDescripcion').val(info.event.extendedProps.descripcion);

        $('#exampleModal').modal();
      },

      events:"{{ url('/eventos/show') }}"

    });
    calendar.setOption('locale', 'Es');

    calendar.render();

    $('#btnAgregar').click(function(){
      ObjEvento = recolectarDatosGUI("POST");
      enviarInformacion(' ', ObjEvento);
    })

    function recolectarDatosGUI(method){
      nuevoEvento={
        id:$('#txtID').val(),
        title:$('#txtTitulo').val(),
        descripcion:$('#txtDescripcion').val(),
        color:$('#txtColor').val(),
        textColor:'#FFFFFF',
        start:$('#txtFecha').val()+ " " +$('#txtHora').val(),
        end:$('#txtFecha').val()+ " " +$('#txtHora').val(),

        '_token':$("meta[name='csrf-token']").attr("content"),
        '_method':method
      }

      return(nuevoEvento);
    }

    function enviarInformacion(accion, objEvento){

      $.ajax({
        type: "POST",
        url:"{{ url('/eventos') }}"+accion,
        data: objEvento,
        success:function(msg){ console.log(msg);},
        error: function(){ alert("Hay un error");}

      });
    }

  });

</script>

@endsection

@section('content')
<div id="calendar"></div>

<!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Datos del evento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">

          ID:
          <input type="text" name="txtID" id="txtID">
          <br/>
          Fecha:
          <input type="text" name="txtFecha" id="txtFecha">
          <br/>
          Título:
          <input type="text" name="txtTitulo" id="txtTitulo">
          <br/>
          Hora:
          <input type="text" name="txtHora" id="txtHora">
          <br/>
          Descripción:
          <textarea name="txtDescripcion" id="txtDescripcion" rows="10" cols="30"></textarea>
          <br/>
          Color:
          <input type="color" name="txtColor" id="txtColor">
          <br/>
        </div>

        <div class="modal-footer">

          <button id="btnAgregar" class="btn btn-success">Agregar</button>
          <button id="btnModificar" class="btn btn-warning">Modificar</button>
          <button id="btnBorrar" class="btn btn-danger">Borrar</button>
          <button id="btnCancelar" class="btn btn-secondary">Cancelar</button>

        </div>

      </div>

    </div>

  </div>


@endsection
