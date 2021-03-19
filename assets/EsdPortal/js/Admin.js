import React, {Component} from 'react';
import { BrowserRouter as Router } from 'react-router-dom';
import {Route, Switch, Redirect, Link, withRouter} from 'react-router-dom';

import Login from "./components/admin/Login";
import Dashboard from "./components/admin/Dashboard";
import NotFound from "./components/NotFound";

export default function Admin(){
    return (
        <>
            <Redirect exact path="/admin" to="/admin/login" />
            <Route path="/admin/login" component={Login} />
            <Route path="/admin/dashboard" component={Dashboard} />
            <Route path="" component={NotFound} />
       </>
    )
}