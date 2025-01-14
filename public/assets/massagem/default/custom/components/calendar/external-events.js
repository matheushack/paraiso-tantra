var CalendarExternalEvents= {
        init:function() {
            var e,
                t,
                i,
                r,
                a;
            $("#m_calendar_external_events .fc-event").each(function() {
                    $(this).data("event", {
                            title: $.trim($(this).text()), stick: !0, className: $(this).data("color"), description: "Lorem ipsum dolor eius mod tempor labore"
                        }
                    ), $(this).draggable( {
                            zIndex: 999, revert: !0, revertDuration: 0
                        }
                    )
                }
            ),
                e=moment().startOf("day"),
                t=e.format("YYYY-MM"),
                i=e.clone().subtract(1, "day").format("YYYY-MM-DD"),
                r=e.format("YYYY-MM-DD"),
                a=e.clone().add(1, "day").format("YYYY-MM-DD"),
                $("#m_calendar").fullCalendar( {
                        header: {
                            left: "prev,next today", center: "title", right: "month,agendaWeek,agendaDay,listWeek"
                        }
                        , eventLimit:!0, navLinks:!0, events:[ {
                            title: "All Day Event", start: t+"-01", description: "Lorem ipsum dolor sit incid idunt ut", className: "m-fc-event--success"
                        }
                            , {
                                title: "Reporting", start: t+"-14T13:30:00", description: "Lorem ipsum dolor incid idunt ut labore", end: t+"-14", className: "m-fc-event--accent"
                            }
                            , {
                                title: "Company Trip", start: t+"-02", description: "Lorem ipsum dolor sit tempor incid", end: t+"-03", className: "m-fc-event--primary"
                            }
                            , {
                                title: "Expo", start: t+"-03", description: "Lorem ipsum dolor sit tempor inci", end: t+"-05", className: "m-fc-event--primary"
                            }
                            , {
                                title: "Dinner", start: t+"-12", description: "Lorem ipsum dolor sit amet, conse ctetur", end: t+"-10"
                            }
                            , {
                                id: 999, title: "Repeating Event", start: t+"-09T16:00:00", description: "Lorem ipsum dolor sit ncididunt ut labore", className: "m-fc-event--danger"
                            }
                            , {
                                id: 1e3, title: "Repeating Event", description: "Lorem ipsum dolor sit amet, labore", start: t+"-16T16:00:00"
                            }
                            , {
                                title: "Conference", start: i, end: a, description: "Lorem ipsum dolor eius mod tempor labore", className: "m-fc-event--accent"
                            }
                            , {
                                title: "Meeting", start: r+"T10:30:00", end: r+"T12:30:00", description: "Lorem ipsum dolor eiu idunt ut labore"
                            }
                            , {
                                title: "Lunch", start: r+"T12:00:00", className: "m-fc-event--info", description: "Lorem ipsum dolor sit amet, ut labore"
                            }
                            , {
                                title: "Meeting", start: r+"T14:30:00", className: "m-fc-event--warning", description: "Lorem ipsum conse ctetur adipi scing"
                            }
                            , {
                                title: "Happy Hour", start: r+"T17:30:00", className: "m-fc-event--metal", description: "Lorem ipsum dolor sit amet, conse ctetur"
                            }
                            , {
                                title: "Dinner", start: r+"T20:00:00", description: "Lorem ipsum dolor sit ctetur adipi scing"
                            }
                            , {
                                title: "Birthday Party", start: a+"T07:00:00", className: "m-fc-event--primary", description: "Lorem ipsum dolor sit amet, scing"
                            }
                            , {
                                title: "Click for Google", url: "http://google.com/", start: t+"-28", description: "Lorem ipsum dolor sit amet, labore"
                            }
                        ], editable:!0, droppable:!0, drop:function(e, t, i, r) {
                            var a=$.fullCalendar.moment(e.format());
                            a.stripTime(), a.time("08:00:00");
                            var n=$.fullCalendar.moment(e.format());
                            n.stripTime(), n.time("12:00:00"), $(this).data("event").start=a, $(this).data("event").end=n, $("#m_calendar_external_events_remove").is(":checked")&&$(this).remove()
                        }
                        , eventRender:function(e, t) {
                            t.hasClass("fc-day-grid-event")?(t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t)): t.hasClass("fc-time-grid-event")?t.find(".fc-title").append('<div class="fc-description">'+e.description+"</div>"): 0!==t.find(".fc-list-item-title").lenght&&t.find(".fc-list-item-title").append('<div class="fc-description">'+e.description+"</div>")
                        }
                    }
                )
        }
    }

;
jQuery(document).ready(function() {
        CalendarExternalEvents.init()
    }

);