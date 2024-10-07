/*
Template Name: Invoika - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Invoice create init Js File
*/

(function () {
    ("use strict");
    var paymentSign = "$";
    Array.from(document.getElementsByClassName("product-line-price")).forEach(
        function (item) {
            item.value = paymentSign + "0.00";
        }
    );
    function otherPayment() {
        var paymentType = document.getElementById(
            "choices-payment-currency"
        ).value;
        paymentSign = paymentType;

        Array.from(
            document.getElementsByClassName("product-line-price")
        ).forEach(function (item) {
            isUpdate = item.value.slice(1);
            item.value = paymentSign + isUpdate;
        });

        recalculateCart();
    }

    var isPaymentEl = document.getElementById("choices-payment-currency");
    var choices = new Choices(isPaymentEl, {
        searchEnabled: false,
    });

    // Profile Img
    document
        .querySelector("#profile-img-file-input")
        .addEventListener("change", function () {
            var preview = document.querySelector(".user-profile-image");
            var file = document.querySelector(".profile-img-file-input")
                .files[0];
            var reader = new FileReader();
            reader.addEventListener(
                "load",
                function () {
                    preview.src = reader.result;
                },
                false
            );
            if (file) {
                reader.readAsDataURL(file);
            }
        });

    flatpickr("#date-field", {
        enableTime: true,
        dateFormat: "d M, Y, h:i K",
    });

    isData();

    function isData() {
        var plus = document.getElementsByClassName("plus"),
            minus = document.getElementsByClassName("minus");

        if (plus) {
            Array.from(plus).forEach(function (e) {
                e.onclick = function (event) {
                    if (parseInt(e.previousElementSibling.value) < 10) {
                        event.target.previousElementSibling.value++;

                        var itemAmount =
                            e.parentElement.parentElement.previousElementSibling.querySelector(
                                ".product-price"
                            ).value;

                        var priceselection =
                            e.parentElement.parentElement.nextElementSibling.querySelector(
                                ".product-line-price"
                            );

                        var productQty =
                            e.parentElement.querySelector(
                                ".product-quantity"
                            ).value;

                        updateQuantity(productQty, itemAmount, priceselection);
                    }
                };
            });
        }

        if (minus) {
            Array.from(minus).forEach(function (e) {
                e.onclick = function (event) {
                    if (parseInt(e.nextElementSibling.value) > 1) {
                        event.target.nextElementSibling.value--;
                        var itemAmount =
                            e.parentElement.parentElement.previousElementSibling.querySelector(
                                ".product-price"
                            ).value;
                        var priceselection =
                            e.parentElement.parentElement.nextElementSibling.querySelector(
                                ".product-line-price"
                            );
                        // var productQty = 1;
                        var productQty =
                            e.parentElement.querySelector(
                                ".product-quantity"
                            ).value;
                        updateQuantity(productQty, itemAmount, priceselection);
                    }
                };
            });
        }
    }

    var count = 1;

    function new_link() {
        count++;
        var tr1 = document.createElement("tr");
        tr1.id = count;
        tr1.className = "product";

        var appendDiv =
            "<select class='form-select border-0 bg-light' onchange='getProductDescription(this.value , this.id)' id='productName-" +
            count +
            "'  required name='product[]'><option value=''>Select Product</option>";
        data.forEach((Element) => {
            appendDiv += `<option value="${Element.id}"> ${Element.product_name} </option>`;
        });
        appendDiv += `</select>`;

        var delLink =
            "<tr>" +
            '<th scope="row" class="product-id">' +
            count +
            "</th>" +
            '<td class="text-start">' +
            '<div class="mb-2">' +
            appendDiv +
            "</div>" +
            '<textarea class="form-control bg-light border-0" id="productDetails-' +
            count +
            '" rows="2" placeholder="Product Details"></textarea>' +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input class="form-control bg-light border-0 product-price" type="number" name="rate[]" id="productRate-' +
            count +
            '" step="0.01" placeholder="$0.00">' +
            "</td>" +
            "<td>" +
            '<div class="input-step">' +
            '<button type="button" class="minus">–</button>' +
            '<input type="number" class="product-quantity" name="quantity[]" id="product-qty-' +
            count +
            '" value="0">' +
            '<button type="button" class="plus">+</button>' +
            "</div>" +
            "</td>" +
            '<td class="text-end">' +
            "<div>" +
            '<input type="text" class="form-control bg-light border-0 product-line-price" name="amount[]" id="productPrice-' +
            count +
            '" value="$0.00" placeholder="$0.00" />' +
            "</div>" +
            "</td>" +
            '<td class="product-removal">' +
            '<a class="btn btn-success">Delete</a>' +
            "</td>" +
            "</tr>";

        tr1.innerHTML = document.getElementById("newForm").innerHTML + delLink;

        document.getElementById("newlink").appendChild(tr1);
        var genericExamples = document.querySelectorAll("[data-trigger]");
        Array.from(genericExamples).forEach(function (genericExamp) {
            var element = genericExamp;
            new Choices(element, {
                placeholderValue: "This is a placeholder set in the config",
                searchPlaceholderValue: "This is a search placeholder",
            });
        });

        isData();
        remove();
        amountKeyup();
        resetRow();
    }

    remove();
    /* Set rates + misc */
    var taxRate = document.getElementById("tax").value / 100;
    var shippingRate = document.getElementById("shippingCharge").value / 1;
    var discountRate = document.getElementById("discount").value / 100;

    function remove() {
        Array.from(document.querySelectorAll(".product-removal a")).forEach(
            function (el) {
                el.addEventListener("click", function (e) {
                    removeItem(e);
                    resetRow();
                });
            }
        );
    }

    function resetRow() {
        Array.from(
            document.getElementById("newlink").querySelectorAll("tr")
        ).forEach(function (subItem, index) {
            var incid = index + 1;
            subItem.querySelector(".product-id").innerHTML = incid;
        });
    }

    /* Recalculate cart */
    function recalculateCart() {
        var subtotal = 0;

        Array.from(document.getElementsByClassName("product")).forEach(
            function (item) {
                Array.from(
                    item.getElementsByClassName("product-line-price")
                ).forEach(function (e) {
                    if (e.value) {
                        subtotal += parseFloat(e.value.slice(1));
                    }
                });
            }
        );

        /* Calculate totals */
        var discount = subtotal * discountRate;
        var tax = (subtotal - discount) * taxRate;

        var shipping = subtotal > 0 ? shippingRate : 0;
        var total = subtotal + tax + shipping - discount;

        document.getElementById("cart-subtotal").value =
            paymentSign + subtotal.toFixed(2);
        document.getElementById("cart-tax").value =
            paymentSign + tax.toFixed(2);
        document.getElementById("cart-shipping").value =
            paymentSign + shipping.toFixed(2);
        document.getElementById("cart-total").value =
            paymentSign + total.toFixed(2);
        document.getElementById("cart-discount").value =
            paymentSign + discount.toFixed(2);
        document.getElementById("totalamountInput").value =
            paymentSign + total.toFixed(2);
        document.getElementById("amountTotalPay").value =
            paymentSign + total.toFixed(2);
    }

    function amountKeyup() {
        // var listArray = [];

        Array.from(document.getElementsByClassName("product-price")).forEach(
            function (item) {
                item.addEventListener("keyup", function (e) {
                    var priceselection =
                        item.parentElement.nextElementSibling.nextElementSibling.querySelector(
                            ".product-line-price"
                        );

                    var amount = e.target.value;
                    var itemQuntity =
                        item.parentElement.nextElementSibling.querySelector(
                            ".product-quantity"
                        ).value;

                    updateQuantity(amount, itemQuntity, priceselection);
                });
            }
        );
    }

    amountKeyup();
    /* Update quantity */
    function updateQuantity(amount, itemQuntity, priceselection) {
        var linePrice = amount * itemQuntity;
        /* Update line price display and recalc cart totals */
        linePrice = linePrice.toFixed(2);
        priceselection.value = paymentSign + linePrice;

        recalculateCart();
    }

    /* Remove item from cart */
    function removeItem(removeButton) {
        removeButton.target.closest("tr").remove();
        recalculateCart();
    }

    //Choise Js
    var genericExamples = document.querySelectorAll("[data-trigger]");
    Array.from(genericExamples).forEach(function (genericExamp) {
        var element = genericExamp;
        new Choices(element, {
            placeholderValue: "This is a placeholder set in the config",
            searchPlaceholderValue: "This is a search placeholder",
        });
    });

    //Address
    function billingFunction() {
        if (document.getElementById("same").checked) {
            document.getElementById("shippingName").value =
                document.getElementById("billingName").value;
            document.getElementById("shippingAddress").value =
                document.getElementById("billingAddress").value;
            document.getElementById("shippingPhoneno").value =
                document.getElementById("billingPhoneno").value;
            document.getElementById("shippingTaxno").value =
                document.getElementById("billingTaxno").value;
        } else {
            document.getElementById("shippingName").value = "";
            document.getElementById("shippingAddress").value = "";
            document.getElementById("shippingPhoneno").value = "";
            document.getElementById("shippingTaxno").value = "";
        }
    }

    var cleaveBlocks = new Cleave("#cardNumber", {
        blocks: [4, 4, 4, 4],
        uppercase: true,
    });

    var genericExamples = document.querySelectorAll(
        '[data-plugin="cleave-phone"]'
    );
    Array.from(genericExamples).forEach(function (genericExamp) {
        var element = genericExamp;
        new Cleave(element, {
            delimiters: ["(", ")", "-"],
            blocks: [0, 3, 3, 4],
        });
    });

    let viewobj;
    var invoices_list = localStorage.getItem("invoices-list");
    var options = localStorage.getItem("option");
    var invoice_no = localStorage.getItem("invoice_no");
    var invoices = JSON.parse(invoices_list);

    if (
        localStorage.getItem("invoice_no") === null &&
        localStorage.getItem("option") === null
    ) {
        var invoice_slug = document.getElementById("invoice_slug").value;
        viewobj = "";
        var value =
            "#" +
            invoice_slug +
            Math.floor(11111111 + Math.random() * 99999999);
        document.getElementById("invoicenoInput").value = value;
    } else {
        viewobj = invoices.find((o) => o.invoice_no === invoice_no);
    }

    // Invoice Data Load On Form
    if (viewobj != "" && options == "edit-invoice") {
        document.getElementById("registrationNumber").value =
            viewobj.company_details.legal_registration_no;
        document.getElementById("companyEmail").value =
            viewobj.company_details.email;
        document.getElementById("companyWebsite").value =
            viewobj.company_details.website;
        new Cleave("#compnayContactno", {
            prefix: viewobj.company_details.contact_no,
            delimiters: ["(", ")", "-"],
            blocks: [0, 3, 3, 4],
        });
        document.getElementById("companyAddress").value =
            viewobj.company_details.address;
        document.getElementById("companyaddpostalcode").value =
            viewobj.company_details.zip_code;

        var preview = document.querySelectorAll(".user-profile-image");
        if (viewobj.img !== "") {
            preview.src = viewobj.img;
        }

        document.getElementById("invoicenoInput").value =
            "#VAL" + viewobj.invoice_no;
        document
            .getElementById("invoicenoInput")
            .setAttribute("readonly", true);
        document.getElementById("date-field").value = viewobj.date;
        document.getElementById("choices-payment-status").value =
            viewobj.status;
        document.getElementById("totalamountInput").value =
            "$" + viewobj.order_summary.total_amount;

        document.getElementById("billingName").value =
            viewobj.billing_address.full_name;
        document.getElementById("billingAddress").value =
            viewobj.billing_address.address;
        new Cleave("#billingPhoneno", {
            prefix: viewobj.company_details.contact_no,
            delimiters: ["(", ")", "-"],
            blocks: [0, 3, 3, 4],
        });
        document.getElementById("billingTaxno").value =
            viewobj.billing_address.tax;

        document.getElementById("shippingName").value =
            viewobj.shipping_address.full_name;
        document.getElementById("shippingAddress").value =
            viewobj.shipping_address.address;
        new Cleave("#shippingPhoneno", {
            prefix: viewobj.company_details.contact_no,
            delimiters: ["(", ")", "-"],
            blocks: [0, 3, 3, 4],
        });

        document.getElementById("shippingTaxno").value =
            viewobj.billing_address.tax;

        var paroducts_list = viewobj.prducts;
        var counter = 1;
        do {
            counter++;
            if (paroducts_list.length > 1) {
                document.getElementById("add-item").click();
            }
        } while (paroducts_list.length - 1 >= counter);

        var counter_1 = 1;

        setTimeout(() => {
            Array.from(paroducts_list).forEach(function (element) {
                document.getElementById("productName-" + counter_1).value =
                    element.product_name;
                document.getElementById("productDetails-" + counter_1).value =
                    element.product_details;
                document.getElementById("productRate-" + counter_1).value =
                    element.rates;
                document.getElementById("product-qty-" + counter_1).value =
                    element.quantity;
                document.getElementById("productPrice-" + counter_1).value =
                    "$" + element.rates * element.quantity;
                counter_1++;
            });
        }, 300);

        document.getElementById("cart-subtotal").value =
            "$" + viewobj.order_summary.sub_total;
        document.getElementById("cart-tax").value =
            "$" + viewobj.order_summary.estimated_tex;
        document.getElementById("cart-discount").value =
            "$" + viewobj.order_summary.discount;
        document.getElementById("cart-shipping").value =
            "$" + viewobj.order_summary.shipping_charge;
        document.getElementById("cart-total").value =
            "$" + viewobj.order_summary.total_amount;

        document.getElementById("choices-payment-type").value =
            viewobj.payment_details.payment_method;
        document.getElementById("cardholderName").value =
            viewobj.payment_details.card_holder_name;

        var cleave = new Cleave("#cardNumber", {
            prefix: viewobj.payment_details.card_number,
            delimiter: " ",
            blocks: [4, 4, 4, 4],
            uppercase: true,
        });
        document.getElementById("amountTotalPay").value =
            "$" + viewobj.order_summary.total_amount;

        document.getElementById("exampleFormControlTextarea1").value =
            viewobj.notes;
    }

    document.addEventListener("DOMContentLoaded", function () {
        // //Form Validation
        var formEvent = document.getElementById("invoice_form");
        var forms = document.getElementsByClassName("needs-validation");
    });
})();
