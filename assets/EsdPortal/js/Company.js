import React, {Component} from 'react';
import { BrowserRouter as Router } from 'react-router-dom';
import {Route, Switch, Redirect, Link, withRouter} from 'react-router-dom';

import NotFound from "./components/NotFound";
import Dashboard from "./components/company/Dashboard";

export default function Company(){
    return (
        <Switch>
            <Redirect exact path="/company" to="/company/dashboard" />
            <Route path="/company/dashboard" component={Dashboard()} />
            {/*<Route path="/company/login" component={Login} />*/}
            {/*<Route path="/register" component={Register} />*/}
            <Route path="" component={NotFound} />
        </Switch>
    )
}