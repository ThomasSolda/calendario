@extends('layouts.app')

@section('scripts')

<link rel="stylesheet" href="{{ asset('fullcalendar/core/main.css')}}">
<link rel="stylesheet" href="{{ asset('fullcalendar/daygrid/main.css')}}">
<link rel="stylesheet" href="{{ asset('fullcalendar/list/main.css')}}">
<link rel="stylesheet" href="{{ asset('fullcalendar/timegrid/main.css')}}">

<script scr="{{ asset('fullcalendar/core/locales/es.js') }}" defer></script>
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
        $('#txtTitulo').val("");
        $('#txtHoraEmpieza').val("");
        $('#txtHoraTermina').val("");
        $('#txtColor').val();
        $('#txtDescription').val("");

        //$('#btnModificar').attr("disabled", true);

        $('#exampleModal').modal();
      },
      eventClick:function(info){

        $('#txtID').val(info.event.id);
        $('#txtTitulo').val(info.event.title);

        mes = (info.event.start.getMonth()+1);
        dia = (info.event.start.getDate());
        anio = (info.event.start.getFullYear());

        mes = (mes<10)?"0"+mes:mes;
        dia = (dia<10)?"0"+dia:dia;

        horaStart = (info.event.start.getHours()+":"+info.event.start.getMinutes());
        horaStart = (info.event.start.getMinutes() == 00)?horaStart+"0":horaStart;

        horaEnd = (info.event.end.getHours()+":"+info.event.end.getMinutes());
        horaEnd = (info.event.end.getMinutes() == 00)?horaEnd+"0":horaEnd;

        $('#txtFecha').val(anio+"-"+mes+"-"+dia);
        $('#txtHoraEmpieza').val(horaStart);
        $('#txtHoraTermina').val(horaEnd);
        $('#txtColor').val(info.event.backgroundColor);
        $('#txtDescription').val(info.event.extendedProps.description);

         //$('#btnAgregar').attr("disabled", true);


        $('#exampleModal').modal();
      },

      events:"{{ url('/eventos/show') }}"

    });

    calendar.setOption('locale', 'es');

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
        //id:$('#txtID').val(),
        title:$('#txtTitulo').val(),
        description:$('#txtDescription').val(),
        color:$('#txtColor').val(),
        textColor:'#FFFFFF',
        start:$('#txtFecha').val()+ " " +$('#txtHoraEmpieza').val(),
        end:$('#txtFecha').val()+ " " +$('#txtHoraTermina').val(),

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
          <input type="text" name="txtID" style="display: none"id="txtID">
          <div class="row">
            <div class="col">
              Fecha:
              <input type="text" name="txtFecha" id="txtFecha" class="form-control">
            </div>
            <div class="col">
              Título:
              <input type="text" name="txtTitulo" id="txtTitulo" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col">
              Hora:
              <input type="text" name="txtHoraEmpieza" id="txtHoraEmpieza" class="form-control">
            </div>
            <div class="col">
              Hora Fin:
              <input type="text" name="txtHoraTermina" id="txtHoraTermina" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col">
            Descripción:
            <input type="text" name="txtDescription" id="txtDescription" class="form-control">
            </div>
          </div>
            Color:
            <input type="color" name="txtColor" id="txtColor" class="form-control">
        </div>

        <div class="modal-footer">

          <button id="btnAgregar" class="btn btn-success">Agregar</button>

          <button id="btnModificar" class="btn btn-warning">Modificar</button>

          <button id="btnEliminar" class="btn btn-danger">Borrar</button>
          <!--<button id="btnCancelar" class="btn btn-secondary">Cancelar</button>-->

        </div>

      </div>

    </div>

  </div>

@endsection
