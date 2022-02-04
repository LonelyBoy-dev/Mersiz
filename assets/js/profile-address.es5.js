"use strict";

(function (ok) {
    "use strict";

    function ProfileAddress() {
        this.ready();
    }

    ProfileAddress.prototype = {
        controller: "ProfileAddress",
        selector: "[data-controller='ProfileAddress']",
        vars: {
            id: 0,
            sectorId: 0,
            createNewMap: true,
            cityId: 0,
            sectorPartId: 0,
            mapService: null,
            mapId: "addresse-map",
            isAddressChange: false,
            oldAddress: '',
            currentAddress: ''
        },
        ready: function ready() {
            var self = this;
            ok.autoClick(self);
            ok.autoChange(self);

            $(document).on(self.controller + '.show.modal', function () {
                self.$elems = {
                    $id: $(self.selector + " #Id"),
                    $sectorId: $(self.selector + " #SectorId"),
                    $sectorPartId: $(self.selector + " #SectorPartId"),
                    $cityId: $(self.selector + " #CityId"),
                    $lat: $(self.selector + " #Lat"),
                    $lng: $(self.selector + " #Lng"),
                    $address: $(self.selector + " #Address"),
                    $address2: $(self.selector + " #Address2"),
                    $type: $(self.selector + " #Type"),
                    $transferee: $(self.selector + " #Transferee"),
                    $mobilePhone: $(self.selector + " #MobilePhone"),
                    $isCheckout: $(self.selector + " #IsCheckout"),
                    $unit: $(self.selector + " #Unit"),
                    $plaque: $(self.selector + " #Plaque")
                };
                //self.$elems.$cityId.prop("disabled", false);
                //self.$elems.$sectorPartId.prop("disabled", false);
                //self.$elems.$sectorId.prop("disabled", false);
                //self.$elems.$lat.prop("disabled", true);
                //self.$elems.$lng.prop("disabled", true);

                self.vars.id = +self.$elems.$id.val() || 0;
                self.vars.sectorId = +self.$elems.$sectorId.val() || 0;

                self.$elems.$address.on('input', function (e) {
                    var code = +$('#location-tab.uk-tab li.uk-active').data("code") || 0;
                    if (code === 1) {
                        var $val = $(this).val();
                        //if ($val === self.vars.oldAddress) {
                        //    self.vars.isAddressChange = false;
                        //} else
                        //    self.vars.isAddressChange = true;
                    }
                });

                //$(document).on("geocoder",
                //    function (data) {
                //        $('#location-address').html(data.address);
                //        // if (self.$elems.$address.val().length === 0 || !self.vars.isAddressChange) {
                //        // self.$elems.$address.val(data.address);
                //        // self.vars.oldAddress = data.address;
                //        //}
                //        self.$elems.$lat.val(data.location.lat);
                //        self.$elems.$lng.val(data.location.lng);
                //        //$("#SearchLocation").focus();
                //    });

                //$(document).on("change.uk.tab",
                //    function (e) {

                //        if (self.vars.createNewMap) {
                //            setTimeout(function () {
                //                self.vars.mapService = new MapService();
                //                self.vars.mapService.createMapWithCurrentLocation(self.vars.mapId, self.$elems.$lat.val(), self.$elems.$lng.val());
                //                self.vars.createNewMap = false;
                //            }, 1000);
                //        }

                //    });
                self.vars.mapService = new MapService();

                if (self.vars.id === 0) {
                    // new
                    self.currentLocation();
                    //setTimeout(function () {
                    //    self.vars.mapService = new MapService();
                    //    self.vars.mapService.createMapWithMarker(self.vars.mapId, self.$elems.$lat.val(), self.$elems.$lng.val());
                    //}, 1000);
                } else {
                    //edit

                    self.$elems.$cityId.trigger('change');
                    setTimeout(function () {
                        var lat = parseFloat(self.$elems.$cityId.find("option:selected").data('lat')) || 0;
                        var lng = parseFloat(self.$elems.$cityId.find("option:selected").data('lng')) || 0;
                        self.vars.mapService.createMapWithMarker(self.vars.mapId, self.$elems.$lat.val() || lat, self.$elems.$lng.val() || lng);
                    }, 500);
                }

                $(document).on('geocoder', function (e) {
                    self.vars.sectorId = 0;
                    //if (self.$elems.$address.val().length === 0)
                    //    self.$elems.$address.val(e.location.address);
                    self.$elems.$lat.val(e.location.lat);
                    self.$elems.$lng.val(e.location.lng);
                    $('#location-address').html(e.location.address);
                    //$.get(`/location/GetSectorPartByLocation?lat=${e.location.lat}&lng=${e.location.lng}`,
                    //    function (d, status) {
                    //        if (d.success) {
                    //            if (!!d.data) {
                    //                var items = d.data.items;
                    //                if (items.length > 0) {
                    //                    self.vars.createNewMap = false;
                    //                    self.vars.sectorId = items[0].sectorId;
                    //                    self.$elems.$sectorId.val(self.vars.sectorId);
                    //                    self.$elems.$cityId.val(items[0].cityId).trigger('change');
                    //                    setTimeout(function () {
                    //                        if (items.length === 1 && items[0].sectorPartId > 0)
                    //                            self.$elems.$sectorPartId.val(items[0].sectorPartId).trigger('change');
                    //                    },
                    //                        500);
                    //                    return 0;
                    //                }
                    //            }
                    //        }
                    //        return 0;
                    //    });
                });
            });

            $(document).on('frmAddAddress.submit.done', function () {
                if (location.href.includes("order/sendorder")) {
                    ok.uiBusy();
                    location.reload();
                } else self.fetchAddress();
            });

            $(document).on("frmAddAddress.submit.errorCode", function (data) {
                switch (data.errorCode) {
                    case 20:
                        ok.notify.confirm(data.message, function () {
                            var data = {};
                            //let code = +$('#location-tab.uk-tab li.uk-active').data("code") || 0;
                            //if (code === 1) {
                            data = {
                                lat: self.$elems.$lat.val(),
                                lng: self.$elems.$lng.val(),
                                type: 1,
                                addresse: {
                                    transferee: self.$elems.$transferee.val(),
                                    mobilePhone: self.$elems.$mobilePhone.val(),
                                    isCheckout: self.$elems.$isCheckout.val(),
                                    lat: self.$elems.$lat.val(),
                                    lng: self.$elems.$lng.val(),
                                    address: self.$elems.$address.val(),
                                    unit: self.$elems.$unit.val(),
                                    plaque: self.$elems.$plaque.val(),
                                    type: 1
                                }
                            };
                            //} else {
                            //    data = {
                            //        cityId: self.$elems.$cityId.val(),
                            //        sectorPartId: self.$elems.$sectorPartId.val(),
                            //        sectorId: self.$elems.$sectorId.val(),
                            //        type: 2,
                            //        addresse: {
                            //            transferee: self.$elems.$transferee.val(),
                            //            isCheckout: self.$elems.$isCheckout.val(),
                            //            cityId: self.$elems.$cityId.val(),
                            //            sectorId: self.$elems.$sectorId.val(),
                            //            sectorPartId: self.$elems.$sectorPartId.val(),
                            //            address: self.$elems.$address2.val(),
                            //            unit: self.$elems.$unit.val(),
                            //            plaque: self.$elems.$plaque.val(),
                            //            type: 2
                            //        }
                            //    }
                            //}
                            $.post("/location/changeShoppingCartStore/", data).done(function (data) {
                                if (typeof data === 'string' && data.indexOf('err_connection_refused') > -1) {
                                    return $(document).trigger('ajaxError');
                                }
                                if (!data.success) {
                                    return ok.notify.danger(data.message);
                                } else {
                                    if (data.errorCode === 22) {
                                        ok.notify.confirm(data.message, function () {
                                            ok.uiBusy();
                                            location.href = "/order/cart";
                                        }, {
                                            labels: {
                                                Ok: "حتما بررسی میکنم"
                                            }
                                        });
                                    } else {
                                        ok.uiBusy();
                                        return location.reload();
                                    }
                                }
                            }).fail(function (jqXHR) {
                                if (jqXHR.status === 0) return;
                                ok.notify.danger("خطا در ارتباط با سرور");
                            });
                        }, {
                            labels: {
                                Ok: "بله",
                                Cancel: "خیر"
                            }
                        });
                        break;
                }
            });
        },
        saveAddress: function saveAddress(target, event) {
            event.preventDefault();
            $('#frmAddAddress').submit();
            //ok.notify.confirm('  .مشتری گرامی، کلیه مشخصات آدرس از جمله موقعیت دقیق جغرافیایی روی نقشه جهت ارسال سفارش حائز اهمیت است', function () {
            //    $('#frmAddAddress').submit();
            //}, {
            //        labels: {
            //            Ok: "بله",
            //            Cancel: "خیر"
            //        }
            //    });
        },
        fetchAddress: function fetchAddress() {
            var self = this;
            ok.loadPartialView("/profile/addresse", null, "#profile-wrapper", function () {
                $(self.selector + "input[name='SelectAddress']").filter("[value=" + self.vars.id + "]").prop('checked', true);
            });
        },
        showModalAddAddress: function showModalAddAddress(target, event) {
            event.preventDefault();
            var self = this;
            ok.showModalDialog("/profile/addAddresseModal/", self.controller);
        },
        showModalEditAddress: function showModalEditAddress(target, event) {
            event.preventDefault();
            var self = this;
            self.vars.id = +$(target).data('id'); //+$(self.selector + " input[name='SelectAddress']:checked ").val() || 0;
            $("#box-option-" + self.vars.id).prop('checked', true);
            if (self.vars.id === 0) {
                return okala.notify.danger("هیچ آدرسی انتخاب نشده است");
            }
            return ok.showModalDialog("/profile/addAddresseModal/" + self.vars.id, self.controller, function () {
                $('.modal-title').text('ویرایش آدرس');
            });
        },
        sectorPartChange: function sectorPartChange(target, event) {
            var self = this;
            self.vars.sectorId = $(target).find("option:selected").data("sectorId");
            self.$elems.$sectorId.val(self.vars.sectorId);
        },
        getSectorParts: function getSectorParts() {
            var self = this;
            var el = self.$elems.$sectorPartId;
            var url = '/Location/GetCitySectorParts/' + self.vars.cityId;
            $('label[for="SectorPartId"]').html('محله <span class="text-danger">در حال بارگزاری...</span>');
            //var url = self.vars.sectorId > 0
            //  ? '/Location/GetCitySectorPartsFromSectorId/' + self.vars.sectorId
            //  : '/Location/GetCitySectorParts/' + self.vars.cityId;
            $.get(url, function (data, status, xhr) {
                if (status === 'success') {
                    if (data.length === 0) return;
                    //self.vars.sectorId = data[0].sectorId || self.vars.sectorId;
                    //self.$elems.$sectorId.val(self.vars.sectorId);
                    $(el).empty();
                    $('<option />', {
                        value: '',
                        text: 'لطفا یک محله را انتخاب کنید...',
                        'data-sector-id': 0
                    }).appendTo(el);
                    $.each(data, function (i, obj) {
                        $('<option />', {
                            value: obj.id,
                            text: obj.name,
                            'data-sector-id': obj.sectorId
                        }).appendTo(el);
                    });

                    if (self.vars.id > 0) {
                        (function () {
                            var sectorPartId = +self.$elems.$sectorPartId.data('sectorPartId');
                            var findSectorPartId = data.filter(function (x) {
                                return x.id === sectorPartId;
                            });
                            if (findSectorPartId.length > 0) self.$elems.$sectorPartId.val(sectorPartId).trigger('change');
                        })();
                    }
                    $('label[for="SectorPartId"]').html('محله');
                }
            });
        },
        cityChange: function cityChange(target, event) {
            var self = this;
            var $this = $(target);
            self.vars.cityId = +$this.val();
            //var lat = parseFloat($this.find("option:selected").data('lat')) || 0;
            //var lng = parseFloat($this.find("option:selected").data('lng')) || 0;
            //if (self.vars.createNewMap &&
            //  lat > 0 &&
            //  lng > 0
            //) {
            //  self.vars.mapService.createMapWithMarker(
            //    self.vars.mapId,
            //    lat,
            //    lng
            //  );
            //}
            self.getSectorParts();
            //self.vars.createNewMap = true;
        },
        selectAddress: function selectAddress(target, event) {
            var self = this;
            self.vars.id = $(target).val();
        },
        deleteAdddress: function deleteAdddress(target, event) {
            event.preventDefault();
            var self = this;
            self.vars.id = +$(target).data('id');
            $("#box-option-" + self.vars.id).prop('checked', true);
            if (self.vars.id === 0) {
                return okala.notify.danger("هیچ آدرسی انتخاب نشده است");
            }

            ok.deleteEntity("/profile/deleteAddresse/" + self.vars.id, null, function () {
                self.fetchAddress();
            });
            return 0;
        },
        setDefaultAddress: function setDefaultAddress(target, event) {
            var self = this,
                id = $(target).data("id");
            $("input[name='IsDefault']").not($(target)).prop('checked', false);
            $.post("/profile/SetDefaultAddress/" + id).done(function (data) {
                if (typeof data === 'string' && data.indexOf('err_connection_refused') > -1) {
                    return $(document).trigger('ajaxError');
                }
                if (!data.success) {
                    return ok.notify.danger(data.message);
                }
                return 0;
                //return self.fetchAddress();
            }).fail(function (jqXHR) {
                if (jqXHR.status === 0) return;
                return ok.notify.danger("عملیات با شکست انجام شد");
            });
        },
        currentLocation: function currentLocation() {
            //this.vars.mapService.getCurrentLocation();
            var self = this;
            setTimeout(function () {

                // self.vars.mapService = new MapService();
                self.vars.mapService.createMapWithCurrentLocation(self.vars.mapId);
                self.createNewMap = false;
            }, 1000);
        }
    };
    return new ProfileAddress();
})(okala);
