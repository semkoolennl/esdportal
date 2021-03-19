import React, {Component} from 'react';
import { BrowserRouter as Router } from 'react-router-dom';
import {Route, Switch, Redirect, withRouter, Link} from 'react-router-dom';

import Home from "./components/visitor/Home";
import Login from "./components/visitor/Login";
import Register from "./components/visitor/Register";
import NotFound from "./components/NotFound";

import MenuAppBar from "./components/visitor/MenuAppBar";
import {Paper} from "@material-ui/core";


export default function Visitor(){
    return (
        <>
            <MenuAppBar />
            <Switch>
                <Redirect exact path="/" to="/home" />
                <Route path="/home" component={Home} />
                <Route path="/login" component={Login} />
                <Route path="/register" component={Register} />
                <Route path="" component={NotFound} />
            </Switch>
        </>
    )
}