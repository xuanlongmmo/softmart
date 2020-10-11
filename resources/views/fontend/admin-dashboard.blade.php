﻿@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div class="content">
            <div class="btn-controls">
                <div class="btn-box-row row-fluid">
                    <a href="#" class="btn-box big span4"><i class=" icon-random"></i><b>{{number_format($grow)}}%</b>
                        <p class="text-muted">
                            Growth</p>
                        </a><a href="#" class="btn-box big span4"><i class="icon-user"></i><b>{{number_format($newUsers)}}</b>
                        <p class="text-muted">
                            New Users</p>
                        </a><a href="#" class="btn-box big span4"><i class="icon-money"></i><b>{{number_format($revenue)}}</b>
                        <p class="text-muted">
                            vnd (monthly)</p>
                    </a>
                </div>
                <div class="btn-box-row row-fluid">
                    <div class="span8">
                        <div class="row-fluid">
                            <div class="span12">
                                <a href="#" class="btn-box small span4"><i class="icon-envelope"></i><b>Messages</b>
                                </a><a href="#" class="btn-box small span4"><i class="icon-group"></i><b>Clients</b>
                                </a><a href="#" class="btn-box small span4"><i class="icon-exchange"></i><b>Expenses</b>
                                </a>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <a href="#" class="btn-box small span4"><i class="icon-save"></i><b>Total Sales</b>
                                </a><a href="#" class="btn-box small span4"><i class="icon-bullhorn"></i><b>Social Feed</b>
                                </a><a href="#" class="btn-box small span4"><i class="icon-sort-down"></i><b>Bounce
                                    Rate</b> </a>
                            </div>
                        </div>
                    </div>
                    <ul class="widget widget-usage unstyled span4">
                        <li>
                            <p>
                                <strong>Order Complete</strong> <span class="pull-right small muted">{{ round($rateorder['complete']) }} %</span>
                            </p>
                            <div class="progress tight">
                                <div class="bar" style="width: {{ $rateorder['complete'] }}%;">
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>
                                <strong>Order Cancel</strong> <span class="pull-right small muted">{{ round($rateorder['cancel']) }} %</span>
                            </p>
                            <div class="progress tight">
                                <div class="bar bar-danger" style="width: {{ $rateorder['cancel'] }}%;">
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>
                                <strong></strong> <span class="pull-right small muted">56%</span>
                            </p>
                            <div class="progress tight">
                                <div class="bar bar-success" style="width: 56%;">
                                </div>
                            </div>
                        </li>
                        <li>
                            <p>
                                <strong>Linux</strong> <span class="pull-right small muted">44%</span>
                            </p>
                            <div class="progress tight">
                                <div class="bar bar-warning" style="width: 44%;">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/#btn-controls-->
        
            <div class="module hide">
                <div class="module-head">
                    <h3>
                        Adjust Budget Range</h3>
                </div>
                <div class="module-body">
                    <div class="form-inline clearfix">
                        <a href="#" class="btn pull-right">Update</a>
                        <label for="amount">
                            Price range:</label>
                        &nbsp;
                        <input type="text" id="amount" class="input-" />
                    </div>
                    <hr />
                    <div class="slider-range">
                    </div>
                </div>
            </div>  
        </div>
        <!--/.content-->
    </div>
    <!--/.span9-->
@endsection