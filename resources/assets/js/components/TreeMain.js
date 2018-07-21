import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Tree from './Tree';

export default class TreeMain extends Component {
    constructor() {
        super();
        this.state = {
            trees: [],
        };
    }

    getTrees() {
        axios.get('api/tree')
            .then(trees => {
                trees=trees.data;
                console.log(trees)

                this.setState({ trees });
            })
    }

    componentDidMount(){
        this.getTrees();
    }

    render() {
        return (
            <div>
                <Tree trees={this.state.trees}/>
            </div>   
        );
    }
}

if (document.getElementById('tree-table')) {
    ReactDOM.render(<TreeMain />, document.getElementById('tree-table'));
}
