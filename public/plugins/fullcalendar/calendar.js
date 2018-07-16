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
                eventUrl = event.url;
            }
            //registration
            if (event.registration === 1) {
                registerUrl.attr('href','/event/' + event.id + '/register');
            }
            let eventData = $('#eventData');
            eventData.find('.modal-title').text(event.title);
            eventData.find('#start-date').text(endDate);
            eventData.find('#end-date').text(startDate);
            eventData.find('#desc').html(event.desc);
            eventData.find('#eventPage').attr('href','/events/'+event.id);
            eventData.find('#editEvent').attr('href','/events/' + event.id + '/edit');
            eventData.find('#deleteEvent').attr('href','/events/delete/' + event.id);
            $('#eventUrl').attr('href',eventUrl);
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