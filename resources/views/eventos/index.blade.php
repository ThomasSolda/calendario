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
      defaultDate: new Date,
      plugins: ['dayGrid', 'interaction', 'timeGrid', 'list'],

      header:{
        left:'prev, next today',
        center:'title',
        right:'dayGridMonth, timeGridWeek, timeGridDay'
      },

      dateClick:function(info){
        $('#txtFecha').val(info.dateStr);
        $('#exampleModal').modal();

        // console.log(info);
        // calendar.addEvent({ title: "Evento X", date: info.dateStr });
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

        mes = (info.event.start.getMonth()+1);
        dia = (info.event.start.getDay());
        anio = (info.event.start.getFullYear());

        mes = (mes<10)?"0"+mes:mes;
        dia = (dia<10)?"0"+dia:dia;

        hora = (info.event.start.getHours()+":"+info.event.start.getMinutes());
        hora = (info.event.start.getMinutes() == 00)?hora+"0":hora;

        $('#txtFecha').val(anio+"-"+mes+"-"+dia);
        $('#txtHora').val(hora);

        $('#txtColor').val(info.event.backgroundColor);

        $('#txtDescription').val(info.event.extendedProps.descripcion);

        $('#exampleModal').modal();
      },

      events:"{{ url('/eventos/show') }}"

    });
    calendar.setOption('locale', 'Es');

    calendar.render();

    $('#btnAgregar').click(function(){
      ObjEvento = recolectarDatosGUI("POST");
      enviarInformacion('', ObjEvento);
    })

    $('#btnEliminar').click(function(){
      ObjEvento = recolectarDatosGUI("DELETE");
      enviarInformacion('/'+$('#txtID').val(), ObjEvento);
    })
    //////////////////ver botón modificar///////////////////////
     $('#btnModificar').click(function(){
       ObjEvento = recolectarDatosGUI("PUT");
       enviarInformacion('/'+$('#txtID').val(), ObjEvento);
     })

    function recolectarDatosGUI(method){
      nuevoEvento={
        id:$('#txtID').val(),
        title:$('#txtTitulo').val(),
        description:$('#txtDescription').val(),
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
        success:function(msg){
          console.log(msg);

          $('#exampleModal').modal('toggle');
          calendar.refetchEvents();

        },
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
          <textarea name="txtDescription" id="txtDescription" rows="10" cols="30"></textarea>
          <br/>
          Color:
          <input type="color" name="txtColor" id="txtColor">
          <br/>
        </div>

        <div class="modal-footer">

          <button id="btnAgregar" class="btn btn-success">Agregar</button>
          <button id="btnModificar" class="btn btn-warning">Modificar</button>
          <button id="btnEliminar" class="btn btn-danger">Borrar</button>
          <button id="btnCancelar" class="btn btn-secondary">Cancelar</button>

        </div>

      </div>

    </div>

  </div>


@endsection
