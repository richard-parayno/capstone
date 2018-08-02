import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import XLSX from 'xlsx';
import ExcelUploadInput from './ExcelUploadInput';
import ExcelUploadConfirmTable from './ExcelUploadConfirmTable';
import ExcelUploadContinue from './ExcelUploadContinue';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

export default class ExcelUploadMain extends Component {
    constructor() {
        super();
        this.state = {
            excelFile: [],
            excelFileErrors: [],
            excelFileClean: [],
        };
        this.handleFile = this.handleFile.bind(this);
        this.exportFile = this.exportFile.bind(this);
    }


    handleFile(file) {
        /* Boilerplate to set up FileReader */
		const reader = new FileReader();
		const rABS = !!reader.readAsBinaryString;
		reader.onload = (e) => {
			/* Parse data */
			const bstr = e.target.result;
			const wb = XLSX.read(bstr, {type:rABS ? 'binary' : 'array'});
			/* Get first worksheet */
			const wsname = wb.SheetNames[0];
			const ws = wb.Sheets[wsname];
			/* Convert array of arrays */
            const excelFile = XLSX.utils.sheet_to_json(ws, {header:"default"});
            //console.log(data);
            //console.log(make_cols(ws['!ref']));
            console.log(excelFile) 

            this.processExcel(excelFile)

		};
        if(rABS) reader.readAsBinaryString(file); else reader.readAsArrayBuffer(file);
        
    }

    processExcel(excelFile) {
        //make a post request to sanitize the data
        axios.post('api/trip/process', excelFile)
        .then(excelFile => {
            excelFile = excelFile.data
            //console.log("Original")
            //console.log(excelFile)

            this.setState({ excelFile: excelFile });

            toast.info("Trip Data Excel File loaded.", {
                position: toast.POSITION.TOP_RIGHT
            })

            // make another post request to separate errors
            return axios.post('api/trip/process/errors', this.state.excelFile) 
                .then(excelFileErrors => {
                    excelFileErrors = excelFileErrors.data
                    //console.log("Errors:")
                    console.log(excelFileError)
                    this.setState({ excelFileErrors: excelFileErrors });

                    // make another post request to display cleaned excel
                    return axios.post('api/trip/process/cleaned', this.state.excelFile)
                        .then(excelFileClean => {
                            excelFileClean = excelFileClean.data
                            //console.log("Clean:")
                            //console.log(excelFileClean)
                            this.setState({ excelFileClean: excelFileClean });

                            // prepare exportable errors
                            console.log("To Export:")
                            console.log(this.state.excelFileErrors)
                            return axios.post('api/trip/process/prepexport', this.state.excelFileErrors)
                                .then(excelFileForExport => {
                                    excelFileForExport = excelFileForExport.data
                                    this.setState({ excelFileForExport: excelFileForExport })
                                    console.log("For Export:")
                                    console.log(this.state.excelFileForExport)
                                })
                        })

                })
        })
        .catch(error => console.log(error))
    }

    exportFile() {
        /* convert state to workbook */
		const ws = XLSX.utils.json_to_sheet(this.state.excelFileForExport);
		const wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(wb, ws, "Trip Upload Errors");
		/* generate XLSX file and send to client */
        XLSX.writeFile(wb, "trip-upload-errors.xlsx")
        
        toast.success("🎉 Trip Data Errors Export Complete!", {
            position: toast.POSITION.TOP_RIGHT
        })
    }

    s2ab(s) {
        var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
        var view = new Uint8Array(buf);  //create uint8array as viewer
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
        return buf;  
    }

    render() {
        if (this.state.excelFileClean.length > 0) {
            return (
                <div>
                    <div className={"twelve columns"} style={{textAlign: 'center'}}>
                        <ExcelUploadInput handleFile={this.handleFile} />
                    </div>
                    <div className={"twelve columns"}>
                        <h1>No Trip Errors</h1>
                        <ExcelUploadConfirmTable data={this.state.excelFileClean} />
                        <br/>
                    </div>
                    <div className={"twelve columns"}>
                        <h1>Contains Trip Errors</h1>
                        <ExcelUploadConfirmTable data={this.state.excelFileErrors} />
                        <br/>
                    </div>
                    <div>
                        <button className={"button-primary u-pull-right"} onClick={this.exportFile}>Export Trip Data Errors</button>
                        <ExcelUploadContinue data={this.state.excelFileClean} />
                    </div>
                    <ToastContainer />
                </div>
            );
        } else {
            return (
                <div className={"twelve columns"} style={{textAlign: 'center'}}>
                    <ExcelUploadInput handleFile={this.handleFile} />
                </div>  
            );
        }
    }
}

if (document.getElementById('excel-upload')) {
    ReactDOM.render(<ExcelUploadMain />, document.getElementById('excel-upload'));
}
