import React, { Component } from 'react';
import 'antd/dist/antd.css';
import {
    Layout, Breadcrumb
} from 'antd';

class ContentBee extends Component {

    render() {
        return (
            <Layout.Content style={{ margin: '0 16px' }}>
                <Breadcrumb style={{ margin: '16px 0' }}>
                    <Breadcrumb.Item>User</Breadcrumb.Item>
                    <Breadcrumb.Item>Bill</Breadcrumb.Item>
                </Breadcrumb>
                <div style={{ padding: 24, background: '#fff', minHeight: 360 }}>
                    <div style={{ float:'right' }}> {this.props.button} </div>
                    <div> {this.props.table} </div>
                </div>
            </Layout.Content>
        );
    }
}

export default ContentBee;