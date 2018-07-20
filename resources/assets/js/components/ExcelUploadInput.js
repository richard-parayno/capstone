import React, { Component } from 'react';

export default class ExcelUploadInput extends Component {
    constructor(props) {
		super(props);
		this.handleChange = this.handleChange.bind(this);
    };
    
	handleChange(e) {
		const files = e.target.files;
		if(files && files[0]) this.props.handleFile(files[0]);
    };
    
    
    render() { 
        /* list of supported file types */
        const SheetJSFT = [
            "xlsx", "csv"
        ].map(function(x) { return "." + x; }).join(",");

        return (
            <form>
                <div>
                    <input type="file"id="file" accept={SheetJSFT} onChange={this.handleChange} />
                </div>
            </form>
        ); 
    };

}

