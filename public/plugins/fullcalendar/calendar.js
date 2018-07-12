/**
 * @copyright   2017 A&M Digital Technologies
 * @author      John Muchiri | john@amdtllc.com
 * @link        https://amdtllc.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
$(document).ready(function () {
    let d = moment(new Date());
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: d.format('YYYY-MM-DD'),
        selectable: true,
        selectHelper: true,
        select: function (start, end) {
            let eventData;
            let modal = $('#new-event');
            let cal = $('#calendar');

            let s = moment(start);
            let e = moment(end);

            modal.find('input[name=start]').val(s.format("YYYY-MM-DD"));
            modal.find('input[name=end]').val(e.subtract(1,"days").format("YYYY-MM-DD"));
            modal.find('input[name=startTime]').val('12:00');
            modal.find('input[name=endTime]').val('23:59');
            modal.modal('show');

            modal.submit(function (e) {
                e.preventDefault();
                let data = modal.find('#new-event-form').serialize();
                $.ajax({
                    url: '/events',
                    data: data,
                    type: 'POST',
                    success: function (response){
                        let modal = $('#new-event');
                        eventData = {
                            title: modal.find('input[name=title]').val(),
                            start: modal.find('input[name=start]').val(),
                            end: modal.find('input[name=end]').val()
                        };
                        modal.modal('hide');
                        cal.fullCalendar('renderEvent', eventData, true);
                        cal.fullCalendar('unselect');
                        sweetAlert('Saved!');
                        window.location.reload();
                    },
                    error: function (error) {
                        swal('Error!')
                    }
                });

            });

        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: '/api/events'
        , eventClick: function (event, jsEvent, view) {
            let s = moment(event.start);
            let startDate = s.format("D,MMMM YYYY, h:mmA");

            let e = moment(event.ends);
            let endDate = ' - ' + e.format("D,MMMM YYYY, h:mmA");

            if (endDate === " - Invalid date") {
                endDate = '';
            }

            let eventUrl = '';
            let registerUrl = '';
            if (event.url !== "") {
                eventUrl = '<a class="btn btn-primary btn-mini" href="' + event.url + '" target="_blank" id="eventUrl" target="_blank">External event link</a>';
            }
            let eventPage = '<a class="btn btn-primary btn-mini pull-left" href="/events/' + event.id + '" target="_blank" id="eventUrl" target="_blank">View event <i class="fa fa-external-link"></i></a>';
            //registration
            if (event.registration === 1) {
                registerUrl = '<a class="btn btn-primary" href="/event/' + event.id + '/register" id="eventReg" target="_blank">Register to Event</a>';
            }
            let eventData = $('#eventData');
            eventData.find('.modal-title').text(event.title);
            eventData.find('#start-date').text(endDate);
            eventData.find('#end-date').text(startDate);
            eventData.find('#desc').html(event.desc);
            eventData.find('#eventPage').html(eventPage);
            eventData.find('#editEvent').html('<a href="/events/' + event.id + '/edit" class="btn btn-primary btn-mini"><i class="fa fa-pencil"></i> </a>');
            eventData.find('#deleteEvent').html('<a href="/events/delete/' + event.id + '" class="btn btn-danger btn-mini delete"><i class="fa fa-trash"></i> </a>');
            $('#eventUrl').html(eventUrl);
            eventData.find('#registerUrl').html(registerUrl);
            eventData.modal('show');
            return false;
        }
    });

    $('.all-day input[type=checkbox]').click(function () {
        $('.end-date').toggle();
    });

    $('input[name=allDay]').click(function () {
        if($(this).is(':checked')){
            $('#e-start-time').hide().find('input').val('11:59 PM');
            $('#e-end-time').hide().find('input').val('12:00 AM');
        } else {
            $('#e-start-time').show().find('input').val('');
            $('#e-end-time').show().find('input').val('');
        }
    });
    $('input[name=registration]').click(function () {
        $('#external-link').toggle();
    })
});