import React, { Component } from "react";
import FacebookLogin from "react-facebook-login/dist/facebook-login-render-props";
import { Button} from "antd";
import { bindActionCreators } from "redux";
import { loginFacebook } from "../../redux/actions/userActions";
import { connect } from "react-redux";
import {Redirect} from 'react-router-dom'


class Facebook extends Component {
  state = {
    isLoggedIn: false,
    userID: "",
    name: "",
    email: "",
    autoload: false,
    lagado: false,
  };

  componentWillReceiveProps = (nextProps) => {
    if (localStorage.getItem("token")) {
        this.setState( {logado : true} );
    }
    console.log(nextProps)
  }

  responseFacebook = response => {
    let token = response.accessToken;
    this.props.loginFacebook({ token: token });
  };

  componentClicked = () => {
      this.setState({autoload: true});
  }

  render() {
    let fbContent;

    if(this.state.logado) {
        return <Redirect to='/dashboard' />
    }

    if (this.state.isLoggedIn) {
      fbContent = null;
    } else {
      fbContent = (
        <FacebookLogin
          appId="922929624721392"
          autoload={false}
          language='pt_BR'
          render={renderProps => (
            <Button
              type="primary"
              onClick={renderProps.onClick}
              icon="facebook"
              loading={this.props.loadingFacebook}
              className="login-form-button button"
            >
              Login com Facebook
            </Button>
          )}
          fields="name,email,picture"
          callback={this.responseFacebook}
        />
      );
    }

    return <div>{fbContent}</div>;
  }
}

function mapStateToProps(state, props) {
    return {
      user: state.userState.user,
      loading: state.userState.loading,
      loadingFacebook: state.userState.loadingFacebook,
      logged: state.userState.logged,
      token: state.userState.token,
      code: state.userState.code
    };
  }
  
  function mapDispatchToProps(dispatch) {
    return bindActionCreators({ loginFacebook }, dispatch);
  }

  export default connect(
    mapStateToProps,
    mapDispatchToProps
  )(Facebook);
