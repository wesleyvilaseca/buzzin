<div class="panel panel-white no-radius">
    <div class="panel-body">
        <ul class="timeline-xs margin-top-20 margin-bottom-20">

            @forelse ($movimentacoes as $mov)
                @if (@$mov->price)
                    <li class="timeline-item success">
                        <div class="margin-left-15">
                            <div class="text-muted text-small">
                                {{ \Carbon\Carbon::parse($mov->created_at)->format('d-m-Y H:m') }}
                            </div>
                            <p>
                                Entrada de {{ $mov->quantity }} {{ $mov->product->title }}(s)
                            </p>
                        </div>
                    </li>
                @endif
                @if (!@$mov->price)
                    <li class="timeline-item danger">
                        <div class="margin-left-15">
                            <div class="text-muted text-small">
                                {{ \Carbon\Carbon::parse($mov->created_at)->format('d-m-Y H:m') }}
                            </div>
                            <p>
                                Saída de {{ $mov->quantity }} {{ $mov->product->title }}(s)
                            </p>
                        </div>
                    </li>
                @endif

            @empty
                <div class="alert-warning">Não há movimentações para listar</div>
            @endforelse

            {{-- <li class="timeline-item">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        12:30
                    </div>
                    <p>
                        Staff Meeting
                    </p>
                </div>
            </li>
            <li class="timeline-item danger list-group-item-danger">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        11:11
                    </div>
                    <p>
                        Completed new layout.
                    </p>
                </div>
            </li>
            <li class="timeline-item info">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        Thu, 12 Jun
                    </div>
                    <p>
                        Contacted
                        <a class="text-info" href="">
                            Microsoft
                        </a>
                        for license upgrades.
                    </p>
                </div>
            </li>
            <li class="timeline-item">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        Tue, 10 Jun
                    </div>
                    <p>
                        Started development new site
                    </p>
                </div>
            </li>
            <li class="timeline-item">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        Sun, 11 Apr
                    </div>
                    <p>
                        Lunch with
                        <a class="text-info" href="">
                            Nicole
                        </a>
                        .
                    </p>
                </div>
            </li>
            <li class="timeline-item warning">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        Wed, 25 Mar
                    </div>
                    <p>
                        server Maintenance.
                    </p>
                </div>
            </li>
            <li class="timeline-item warning">
                <div class="margin-left-15">
                    <div class="text-muted text-small">
                        Wed, 25 Mar
                    </div>
                    <p>
                        server Maintenance.
                    </p>
                </div>
            </li> --}}
        </ul>
    </div>
    {{-- <div class="panel-footer">
        <div class="clearfix padding-5 padding-top-10 padding-bottom-10 space5">
            <div class="col-xs-4 text-center no-padding">
                <div class="border-right border-dark">
                    <span class="text-bold block text-extra-large">90%</span>
                    <span class="text-light">Satisfied</span>
                </div>
            </div>
            <div class="col-xs-4 text-center no-padding">
                <div class="border-right border-dark">
                    <span class="text-bold block text-extra-large">2%</span>
                    <span class="text-light">Unsatisfied</span>
                </div>
            </div>
            <div class="col-xs-4 text-center no-padding">
                <span class="text-bold block text-extra-large">8%</span>
                <span class="text-light">NA</span>
            </div>
        </div>
    </div> --}}
</div>

<style>
    .margin-negative-5 {
        margin: -5px !important
    }

    .margin-5 {
        margin: 5px !important
    }

    .margin-10 {
        margin: 10px !important
    }

    .margin-15 {
        margin: 15px !important
    }

    .margin-20 {
        margin: 20px !important
    }

    .margin-25 {
        margin: 25px !important
    }

    .margin-30 {
        margin: 30px !important
    }

    .margin-35 {
        margin: 35px !important
    }

    .margin-40 {
        margin: 40px !important
    }

    .margin-bottom-0 {
        margin-bottom: 0 !important
    }

    .margin-bottom-5 {
        margin-bottom: 5px !important
    }

    .margin-bottom-10 {
        margin-bottom: 10px !important
    }

    .margin-bottom-15 {
        margin-bottom: 15px !important
    }

    .margin-bottom-20 {
        margin-bottom: 20px !important
    }

    .margin-bottom-25 {
        margin-bottom: 25px !important
    }

    .margin-bottom-30 {
        margin-bottom: 30px !important
    }

    .margin-bottom-35 {
        margin-bottom: 35px !important
    }

    .margin-bottom-40 {
        margin-bottom: 40px !important
    }

    .margin-bottom-45 {
        margin-bottom: 45px !important
    }

    .margin-bottom-50 {
        margin-bottom: 50px !important
    }

    .margin-top-0 {
        margin-top: 0 !important
    }

    .margin-top-5 {
        margin-top: 5px !important
    }

    .margin-top-10,
    .note-editor textarea {
        margin-top: 10px !important
    }

    .margin-top-15 {
        margin-top: 15px !important
    }

    .margin-top-20 {
        margin-top: 20px !important
    }

    .margin-top-25 {
        margin-top: 25px !important
    }

    .margin-top-30 {
        margin-top: 30px !important
    }

    .margin-top-35 {
        margin-top: 35px !important
    }

    .margin-top-40 {
        margin-top: 40px !important
    }

    .margin-top-45 {
        margin-top: 45px !important
    }

    .margin-top-50 {
        margin-top: 50px !important
    }

    .margin-right-0 {
        margin-right: 0 !important
    }

    .margin-right-5 {
        margin-right: 5px !important
    }

    .margin-right-10 {
        margin-right: 10px !important
    }

    .margin-right-15 {
        margin-right: 15px !important
    }

    .margin-right-20 {
        margin-right: 20px !important
    }

    .margin-right-25 {
        margin-right: 25px !important
    }

    .margin-right-30 {
        margin-right: 30px !important
    }

    .margin-right-35 {
        margin-right: 35px !important
    }

    .margin-right-40 {
        margin-right: 40px !important
    }

    .margin-right-45 {
        margin-right: 45px !important
    }

    .margin-right-50 {
        margin-right: 50px !important
    }

    .margin-left-0 {
        margin-left: 0 !important
    }

    .margin-left-5 {
        margin-left: 5px !important
    }

    .margin-left-10 {
        margin-left: 10px !important
    }

    .margin-left-15 {
        margin-left: 15px !important
    }

    .margin-left-20 {
        margin-left: 20px !important
    }

    .margin-left-25 {
        margin-left: 25px !important
    }

    .margin-left-30 {
        margin-left: 30px !important
    }

    .margin-left-35 {
        margin-left: 35px !important
    }

    .margin-left-40 {
        margin-left: 40px !important
    }

    .margin-left-45 {
        margin-left: 45px !important
    }

    .margin-left-50 {
        margin-left: 50px !important
    }

    div.timeline {
        margin: 0;
        overflow: hidden;
        position: relative
    }

    div.timeline .columns {
        margin: 0;
        padding: 0;
        list-style: none
    }

    div.timeline .columns>li:nth-child(2n + 1) {
        float: left;
        width: 50%;
        clear: left
    }

    div.timeline .columns>li:nth-child(2n + 1) .timeline_element {
        float: right;
        margin-right: 30px;
        left: 0;
        opacity: 1
    }

    div.timeline .columns>li:nth-child(2n + 1) .timeline_element:before {
        right: -27px;
        top: 15px
    }

    div.timeline .columns>li:nth-child(2n + 1) .timeline_element:after {
        right: -35px;
        top: 10px
    }

    div.timeline .columns>li:nth-child(2n + 2) {
        float: right;
        margin-top: 20px;
        width: 50%;
        clear: right
    }

    div.timeline .columns>li:nth-child(2n + 2) .timeline_element {
        float: left;
        margin-left: 30px;
        opacity: 1;
        right: 0
    }

    div.timeline .columns>li:nth-child(2n + 2) .timeline_element:before {
        left: -27px;
        top: 15px
    }

    div.timeline .columns>li:nth-child(2n + 2) .timeline_element:after {
        left: -35px;
        top: 10px
    }

    div.timeline .date_separator {
        clear: both;
        height: 60px;
        position: relative;
        text-align: center
    }

    div.timeline .date_separator span {
        border-radius: 5px;
        height: 30px;
        line-height: 30px;
        margin-top: -16px;
        position: absolute;
        width: 200px;
        top: 50%;
        left: 50%;
        margin-left: -100px;
        background-color: #58748B;
        color: #fff
    }

    div.timeline .spine {
        border-radius: 2px;
        position: absolute;
        top: 0;
        width: 4px;
        left: 50%;
        margin-left: -2px;
        bottom: 0;
        background-color: rgba(0, 0, 0, .1)
    }

    div.timeline .column_center .timeline_element {
        margin: 20px auto;
        opacity: 1
    }

    div.timeline .column_center .timeline_element:after,
    div.timeline .column_center .timeline_element:before {
        display: none
    }

    .timeline_element {
        border-radius: 5px;
        clear: both;
        margin: 30px 0;
        padding: 20px;
        opacity: 0;
        position: relative;
        transition: all .2s linear 0s;
        min-width: 66.6667%;
        text-shadow: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, .1)
    }

    .timeline_element:after,
    .timeline_element:before {
        content: "";
        position: absolute;
        display: block
    }

    .timeline_element.partition-white {
        border: 1px solid rgba(0, 0, 0, .07)
    }

    .timeline_element.partition-white:hover {
        border: 1px solid rgba(0, 0, 0, .04)
    }

    .timeline_element.partition-white:after {
        background-color: #fff
    }

    .timeline_element.partition-white:hover:after {
        background-color: #c3c2c7;
        border: 1px solid #fff
    }

    .timeline_element.partition-green {
        border: none;
        color: #fff
    }

    .timeline_element.partition-green:hover {
        border: none
    }

    .timeline_element.partition-green:after {
        background-color: #5A8770
    }

    .timeline_element.partition-green:hover:after {
        background-color: #fff;
        border: 1px solid #5A8770
    }

    .timeline_element.partition-orange {
        border: none;
        color: #fff
    }

    .timeline_element.partition-orange:hover {
        border: none
    }

    .timeline_element.partition-orange:after {
        background-color: #F18636
    }

    .timeline_element.partition-orange:hover:after {
        background-color: #fff;
        border: 1px solid #F18636
    }

    .timeline_element.partition-blue {
        border: none;
        color: #fff
    }

    .timeline_element.partition-blue:hover {
        border: none
    }

    .timeline_element.partition-blue:after {
        background-color: #407887
    }

    .timeline_element.partition-blue:hover:after {
        background-color: #fff;
        border: 1px solid #407887
    }

    .timeline_element.partition-red {
        border: none;
        color: #fff
    }

    .timeline_element.partition-red:hover {
        border: none
    }

    .timeline_element.partition-red:after {
        background-color: #C82E29
    }

    .timeline_element.partition-red:hover:after {
        background-color: #fff;
        border: 1px solid #C82E29
    }

    .timeline_element.partition-azure {
        border: none;
        color: #fff
    }

    .timeline_element.partition-azure:hover {
        border: none
    }

    .timeline_element.partition-azure:after {
        background-color: #5B9BD1
    }

    .timeline_element.partition-azure:hover:after {
        background-color: #fff;
        border: 1px solid #5B9BD1
    }

    .timeline_element.partition-purple {
        border: none;
        color: #fff
    }

    .timeline_element.partition-purple:hover {
        border: none
    }

    .timeline_element.partition-purple:after {
        background-color: #9A89B5
    }

    .timeline_element.partition-purple:hover:after {
        background-color: #fff;
        border: 1px solid #9A89B5
    }

    .timeline_element:hover {
        box-shadow: 0 0 6px rgba(0, 0, 0, .2)
    }

    .timeline_element:before {
        height: 0;
        width: 26px;
        border-top: 1px dashed #CCC
    }

    .timeline_element:after {
        border-radius: 100%;
        height: 10px;
        width: 10px;
        background-color: #BBB;
        border: 1px solid #FFF;
        box-shadow: 0 0 2px rgba(0, 0, 0, .2)
    }

    .timeline_element:hover:after {
        background-color: #FFF;
        border: 1px solid #CCC;
        z-index: 100
    }

    .timeline_element .timeline_title {
        overflow: hidden;
        position: relative;
        text-transform: uppercase;
        padding-top: 10px;
        white-space: nowrap
    }

    .timeline_element .timeline_title h4 {
        line-height: 30px
    }

    .timeline_element .timeline_date {
        display: block
    }

    .timeline_element .timeline_date .day {
        font-size: 52px;
        letter-spacing: -2px
    }

    .timeline_element .timeline_content {
        padding-top: 10px;
        padding-bottom: 10px
    }

    .timeline_element .readmore {
        padding: 10px 0;
        text-align: right
    }

    .timeline-scrubber {
        padding: 8px 0 8px 1px;
        top: 60px;
        right: 0;
        width: 100px;
        z-index: 1;
        list-style: none;
        position: absolute
    }

    .timeline-scrubber li {
        margin-bottom: 1px
    }

    .timeline-scrubber li:last-child a,
    .timeline-scrubber li:nth-last-child(2) a {
        border-color: #fff;
        color: #fff
    }

    .timeline-scrubber a {
        border-left: 5px solid #f7f7f8;
        color: #f7f7f8;
        display: block;
        font-weight: 400;
        outline: 0;
        padding: 4px 0 4px 6px
    }

    .timeline-scrubber a:hover {
        border-color: #c3c2c7 !important;
        color: #c3c2c7 !important
    }

    .timeline-scrubber .selected>a {
        border-left-color: #aeacb4 !important;
        color: #aeacb4 !important;
        font-weight: 700 !important
    }

    .ie8 div.timeline_element:after,
    .ie8 div.timeline_element:before {
        display: none
    }

    .timeline-xs {
        margin: 0;
        padding: 0;
        list-style: none
    }

    .timeline-xs .timeline-item {
        position: relative;
        border-left: 1px solid #c8c7cc
    }

    .timeline-xs .timeline-item:after {
        background-color: #fff;
        border-color: #58748B;
        border-radius: 10px;
        border-style: solid;
        border-width: 1px;
        height: 9px;
        left: 0;
        margin-left: -5px;
        position: absolute;
        width: 9px;
        clear: both;
        bottom: auto;
        top: 4px
    }

    .timeline-xs .timeline-item p {
        margin: 0;
        padding-bottom: 10px
    }

    .timeline-xs .timeline-item.success {
        border-left-color: #5cb85c
    }

    .timeline-xs .timeline-item.success:after {
        border-color: #5cb85c
    }

    .timeline-xs .timeline-item.danger {
        border-left-color: #d43f3a
    }

    .timeline-xs .timeline-item.danger:after {
        border-color: #d43f3a
    }

    .timeline-xs .timeline-item.info {
        border-left-color: #46b8da
    }

    .timeline-xs .timeline-item.info:after {
        border-color: #46b8da
    }

    .timeline-xs .timeline-item.warning {
        border-left-color: #eea236
    }

    .timeline-xs .timeline-item.warning:after {
        border-color: #eea236
    }

    .timeline-xs .timeline-item:after,
    .timeline-xs .timeline-item:before {
        content: " ";
        display: table
    }

    @media (max-width:991px) {
        div.timeline {
            margin: 0
        }

        div.timeline .columns li {
            float: none !important;
            width: 100% !important
        }

        .timeline_element {
            margin: 20px auto !important
        }

        .timeline-scrubber,
        .timeline_element:after,
        .timeline_element:before {
            display: none
        }
    }
</style>
