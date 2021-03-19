import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter as Router,
    Redirect,
    Route,
    Switch,
    useParams,
    useRouteMatch
} from 'react-router-dom';

import CssBaseline from '@material-ui/core/CssBaseline';
import { createMuiTheme } from '@material-ui/core/styles';
import { ThemeProvider } from '@material-ui/styles';

import '../css/app.css';
import Admin from "./Admin";
import Company from "./Company";
import Visitor from "./Visitor";


function Routes() {
    const theme = createMuiTheme({
        palette: {
            type: 'dark',
        },
    });

    return (
        <ThemeProvider theme={theme}>
            <CssBaseline />
            <Router>
                <Switch>
                    <Route path="/admin" component={Admin}/>
                    <Route path="/company" component={Company}/>
                    <Route path="*" component={Visitor}/>
                </Switch>
            </Router>
        </ThemeProvider>
    )
}


ReactDOM.render(<Routes />, document.getElementById('root'));
