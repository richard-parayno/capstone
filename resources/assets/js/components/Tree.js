import React, { Component } from 'react';
import ReactTable from "react-table";
import matchSorter from 'match-sorter'


export default class Tree extends Component {

    render() {
        const trees = this.props.trees;

        const columns = [{
            Header: 'Institution',
            id: 'institutionName',
            accessor: 'institutionName', // String-based value accessors!
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['institutionName'] }),
            filterAll: true
          }, {
            Header: 'Number of Planted Trees',
            id: 'numOfPlantedTrees',
            accessor: 'numOfPlantedTrees',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['numOfPlantedTrees'] }),
            filterAll: true
          }, {
            Header: 'Date Planted',
            id: 'datePlanted',
            accessor: 'datePlanted',
            filterMethod: (filter, rows) =>
                matchSorter(rows, filter.value, { keys: ['datePlanted'] }),
            filterAll: true
          }]; 
          
        
    
        return (
            <ReactTable
                minRows={5}
                pageSize={5}
                filterable
                defaultFilterMethod={(filter, row) =>
                    String(row[filter.id]) === filter.value}
                data={trees}
                columns={columns}
                className="-striped -highlight"
                />
        );
    }
}
