import React, { Component } from "react";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import {
  getAllapiarios,
  detalhesApiario,
  deleteApiario
} from "../../redux/actions/apiarioActions";
import { getAllColmeias } from "../../redux/actions/colmeiasByApiarioActions";
import ModalApiario from "../../pages/Dashboard/subpages/Apiarios/ModalApiario";
import ModalOpcoes from "../../pages/Dashboard/subpages/Apiarios/ModalOpcoes";
import ModalDetalhesMap from "../ModalDetalhesMap";
import { uris, colors } from "../../assets";
import { notification, Icon } from "antd";
import MapView from "./MapView";
import ModalDetalhesColmeia from "../../pages/Dashboard/subpages/Apiarios/ModalDetalhesColmeia";

/* global google */
class MapContainer extends Component {
  constructor(props) {
    super(props);

    this.state = {
      isEdicao: false,
      apiarioId: null,
      apiario: {},
      longitude: null,
      endereco: null,
      latitude: null,
      visible: false,
      center: null,
      lng: -38.2052,
      lat: -6.1123,
      zoom: 8
    };

    this.openModalDetalhes = this.openModalDetalhes.bind(this);
  }

  componentDidMount = () => {
    this.props.getAllapiarios();
  };

  componentWillReceiveProps = nextProps => {
    if (nextProps.code === 200) {
      this.refs.opendModalOpcoes.setModalVisible(false);
    } else if (nextProps.code === 204) {
      this.refs.opendModalOpcoes.setModalVisible(false);
      notification.open({
        message: "Operação realizado com sucesso",
        description: "Apiário removido com sucesso",
        icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
      });
    }
  };

  handleBoundsChanged = () => {
    this.setState({
      bounds: this._map.getBounds(),
      center: this._map.getCenter()
    });
  };

  handleSearchBoxMounted = searchBox => {
    this._searchBox = searchBox;
  };

  onPlacesChanged = () => {
    const places = this._searchBox.getPlaces();
    const bounds = new google.maps.LatLngBounds();

    places.forEach(place => {
      if (place.geometry.viewport) bounds.union(place.geometry.viewport);
      else bounds.extend(place.geometry.location);
    });
    const nextMarkers = places.map(place => ({
      position: place.geometry.location
    }));

    let lat =
      nextMarkers[0] && nextMarkers[0].position
        ? nextMarkers[0].position.lat()
        : null;
    let lng =
      nextMarkers[0] && nextMarkers[0].position
        ? nextMarkers[0].position.lng()
        : null;

    this.setState({ lat: lat, lng: lng, zoom: 15 });
  };

  handleRightClick = event => {
    if (this.props.cadastroAbilitado) {
      this.setState({ visible: true, isEdicao: false, apiario: {} });
    }

    var latitude = event.latLng.lat(),
      longitude = event.latLng.lng();

    this.setState({ latitude: latitude, longitude: longitude });
  };

  handleMarkerClick = apiarioId => {
    if (!this.props.cadastroAbilitado) {
      this.props.detalhesApiario(apiarioId);
      this.refs.opendModalDetalhes.setModalVisible(true);
    } else {
      this.setState({ apiarioId: apiarioId });
      this.refs.opendModalOpcoes.setModalVisible(true);
    }
  };

  openModalDetalhes = () => {
    this.props.detalhesApiario(this.state.apiarioId);
    this.refs.opendModalDetalhes.setModalVisible(true);
  };

  openModalDetalhesColmeia = () => {
    this.props.getAllColmeias(this.state.apiarioId);
    this.refs.openModalDetalhesColmeia.setModalVisible(true);
  };

  handleDelete = () => {
    this.props.deleteApiario(this.state.apiarioId);
  };

  openModalApiario = () => {
    this.refs.opendModalOpcoes.setModalVisible(false);
    this.props.detalhesApiario(this.state.apiarioId);
    this.setState({
      visible: true,
      isEdicao: true,
      apiario: this.props && this.props.apiarioDetalhes
    });
  };

  render() {
    const {
      visible,
      latitude,
      longitude,
      lat,
      lng,
      zoom,
      isEdicao
    } = this.state;
    const {
      listApiarios,
      apiarioDetalhes,
      loadingApiario,
      colmeias,
      loadingColmeia
    } = this.props || [];
    const { apiario } = this.state;

    return (
      <div>
        <MapView
          googleMapURL={uris.GOOGLE_MAPS_URI}
          loadingElement={
            <div
              style={{
                width: `100%`,
                height: `100%`,
                display: `block`,
                flex: 1
              }}
            />
          }
          mapElement={
            <div
              style={{
                width: `100%`,
                height: `60vh`,
                display: `block`
              }}
              id="beecheck-maps"
            />
          }
          containerElement={
            <div
              style={{
                boxShadow: `0 6px 10px -4px rgba(0,0,0,50)`,
                border: `0 none`
              }}
            />
          }
          onRightClick={this.handleRightClick}
          onMarkerClick={this.handleMarkerClick}
          onPlacesChanged={this.onPlacesChanged}
          lat={lat}
          lng={lng}
          zoom={zoom}
          bounds={null}
          onSearchBoxMounted={this.handleSearchBoxMounted}
          apiarios={listApiarios}
        />
        <ModalOpcoes
          ref={"opendModalOpcoes"}
          openModalDetalhes={this.openModalDetalhes}
          openModalDetalhesColmeia={this.openModalDetalhesColmeia}
          openModalApiario={this.openModalApiario}
          handleDelete={this.handleDelete}
        />
        <ModalDetalhesMap
          ref={"opendModalDetalhes"}
          apiario={apiarioDetalhes}
          loadingApiario={loadingApiario}
        />

        <ModalDetalhesColmeia
          ref={"openModalDetalhesColmeia"}
          colmeias={colmeias}
          loadingColmeia={loadingColmeia}
        />
        <ModalApiario
          visible={visible}
          latitude={latitude}
          longitude={longitude}
          edicao={isEdicao}
          apiario={apiario}
          onCloseModal={() => this.setState({ visible: false })}
        />
      </div>
    );
  }
}

function mapStateToProps(state, props) {
  return {
    apiario: state.apiarioState.apiario,
    apiarioDetalhes: state.apiarioState.apiarioDetalhes,
    listApiarios: state.apiarioState.listApiarios,
    loadingApiario: state.apiarioState.loadingApiario,
    code: state.apiarioState.code,
    messageApiario: state.apiarioState.messageApiario,
    colmeias: state.colmeiaStateReducer.colmeias,
    loadingColmeia: state.colmeiaStateReducer.loadingColmeia
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    { getAllapiarios, detalhesApiario, deleteApiario, getAllColmeias },
    dispatch
  );
}

export default connect(
  mapStateToProps,
  mapDispatchToProps,
  null,
  { forwardRef: true }
)(MapContainer);
