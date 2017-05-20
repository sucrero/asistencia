--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.12
-- Dumped by pg_dump version 9.4.12
-- Started on 2017-05-20 19:12:19 -04

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 1 (class 3079 OID 11861)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2074 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 173 (class 1259 OID 16385)
-- Name: asistencia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE asistencia (
    idasis integer NOT NULL,
    idper integer,
    hora time without time zone,
    fecha date
);


ALTER TABLE asistencia OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16388)
-- Name: asistencia_idasis_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE asistencia_idasis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE asistencia_idasis_seq OWNER TO postgres;

--
-- TOC entry 2075 (class 0 OID 0)
-- Dependencies: 174
-- Name: asistencia_idasis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE asistencia_idasis_seq OWNED BY asistencia.idasis;


--
-- TOC entry 175 (class 1259 OID 16390)
-- Name: diasfestivo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diasfestivo (
    idfestivo integer NOT NULL,
    fecha date,
    descfest character varying,
    fecha2 date
);


ALTER TABLE diasfestivo OWNER TO postgres;

--
-- TOC entry 2076 (class 0 OID 0)
-- Dependencies: 175
-- Name: COLUMN diasfestivo.descfest; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN diasfestivo.descfest IS 'nombre dle dia festivo';


--
-- TOC entry 176 (class 1259 OID 16396)
-- Name: diasfestivo_idfestivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diasfestivo_idfestivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE diasfestivo_idfestivo_seq OWNER TO postgres;

--
-- TOC entry 2077 (class 0 OID 0)
-- Dependencies: 176
-- Name: diasfestivo_idfestivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diasfestivo_idfestivo_seq OWNED BY diasfestivo.idfestivo;


--
-- TOC entry 177 (class 1259 OID 16398)
-- Name: horario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE horario (
    idhor integer NOT NULL,
    horentrada time without time zone,
    horasalida time without time zone,
    descripcionhor character varying(100)
);


ALTER TABLE horario OWNER TO postgres;

--
-- TOC entry 2078 (class 0 OID 0)
-- Dependencies: 177
-- Name: COLUMN horario.horentrada; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN horario.horentrada IS 'hora de inicio manana';


--
-- TOC entry 2079 (class 0 OID 0)
-- Dependencies: 177
-- Name: COLUMN horario.horasalida; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN horario.horasalida IS 'hora de fin manana';


--
-- TOC entry 178 (class 1259 OID 16401)
-- Name: horario_idhor_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE horario_idhor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE horario_idhor_seq OWNER TO postgres;

--
-- TOC entry 2080 (class 0 OID 0)
-- Dependencies: 178
-- Name: horario_idhor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE horario_idhor_seq OWNED BY horario.idhor;


--
-- TOC entry 179 (class 1259 OID 16403)
-- Name: horario_persona; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE horario_persona (
    idhorper integer NOT NULL,
    idper integer,
    idhor integer
);


ALTER TABLE horario_persona OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 16406)
-- Name: horario_persona_idhorper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE horario_persona_idhorper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE horario_persona_idhorper_seq OWNER TO postgres;

--
-- TOC entry 2081 (class 0 OID 0)
-- Dependencies: 180
-- Name: horario_persona_idhorper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE horario_persona_idhorper_seq OWNED BY horario_persona.idhorper;


--
-- TOC entry 181 (class 1259 OID 16408)
-- Name: permiso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE permiso (
    idper integer NOT NULL,
    descper character varying(60),
    abrev character varying(10)
);


ALTER TABLE permiso OWNER TO postgres;

--
-- TOC entry 2082 (class 0 OID 0)
-- Dependencies: 181
-- Name: COLUMN permiso.descper; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN permiso.descper IS 'descripcion permiso';


--
-- TOC entry 182 (class 1259 OID 16411)
-- Name: permiso_idper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE permiso_idper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE permiso_idper_seq OWNER TO postgres;

--
-- TOC entry 2083 (class 0 OID 0)
-- Dependencies: 182
-- Name: permiso_idper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE permiso_idper_seq OWNED BY permiso.idper;


--
-- TOC entry 183 (class 1259 OID 16413)
-- Name: permiso_persona; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE permiso_persona (
    idperper integer NOT NULL,
    idpersona integer,
    desde date,
    hasta date,
    descripcionper character varying(300),
    idpermiso integer
);


ALTER TABLE permiso_persona OWNER TO postgres;

--
-- TOC entry 2084 (class 0 OID 0)
-- Dependencies: 183
-- Name: COLUMN permiso_persona.idperper; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN permiso_persona.idperper IS 'id permiso persona';


--
-- TOC entry 184 (class 1259 OID 16416)
-- Name: permiso_persona_idperper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE permiso_persona_idperper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE permiso_persona_idperper_seq OWNER TO postgres;

--
-- TOC entry 2085 (class 0 OID 0)
-- Dependencies: 184
-- Name: permiso_persona_idperper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE permiso_persona_idperper_seq OWNED BY permiso_persona.idperper;


--
-- TOC entry 185 (class 1259 OID 16418)
-- Name: personal; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE personal (
    idper integer NOT NULL,
    cedper character varying(12),
    nomper character varying(50),
    apeper character varying(50),
    emailper character varying(50),
    dependencia character varying(50),
    telfper character varying(11),
    cargo character varying(50),
    condicion character varying(50),
    status character varying(10)
);


ALTER TABLE personal OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16421)
-- Name: personal_idper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE personal_idper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE personal_idper_seq OWNER TO postgres;

--
-- TOC entry 2086 (class 0 OID 0)
-- Dependencies: 186
-- Name: personal_idper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE personal_idper_seq OWNED BY personal.idper;


--
-- TOC entry 187 (class 1259 OID 16423)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuario (
    idusuario integer NOT NULL,
    nombreusu character varying(50),
    claveusu character varying(100),
    tipousu character varying(50),
    fechausu timestamp without time zone,
    statususu character varying(20),
    idper integer
);


ALTER TABLE usuario OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16426)
-- Name: usuario_idusuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuario_idusuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE usuario_idusuario_seq OWNER TO postgres;

--
-- TOC entry 2087 (class 0 OID 0)
-- Dependencies: 188
-- Name: usuario_idusuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuario_idusuario_seq OWNED BY usuario.idusuario;


--
-- TOC entry 1928 (class 2604 OID 16428)
-- Name: idasis; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asistencia ALTER COLUMN idasis SET DEFAULT nextval('asistencia_idasis_seq'::regclass);


--
-- TOC entry 1929 (class 2604 OID 16429)
-- Name: idfestivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diasfestivo ALTER COLUMN idfestivo SET DEFAULT nextval('diasfestivo_idfestivo_seq'::regclass);


--
-- TOC entry 1930 (class 2604 OID 16430)
-- Name: idhor; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario ALTER COLUMN idhor SET DEFAULT nextval('horario_idhor_seq'::regclass);


--
-- TOC entry 1931 (class 2604 OID 16431)
-- Name: idhorper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario_persona ALTER COLUMN idhorper SET DEFAULT nextval('horario_persona_idhorper_seq'::regclass);


--
-- TOC entry 1932 (class 2604 OID 16432)
-- Name: idper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso ALTER COLUMN idper SET DEFAULT nextval('permiso_idper_seq'::regclass);


--
-- TOC entry 1933 (class 2604 OID 16433)
-- Name: idperper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso_persona ALTER COLUMN idperper SET DEFAULT nextval('permiso_persona_idperper_seq'::regclass);


--
-- TOC entry 1934 (class 2604 OID 16434)
-- Name: idper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY personal ALTER COLUMN idper SET DEFAULT nextval('personal_idper_seq'::regclass);


--
-- TOC entry 1935 (class 2604 OID 16435)
-- Name: idusuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario ALTER COLUMN idusuario SET DEFAULT nextval('usuario_idusuario_seq'::regclass);


--
-- TOC entry 1937 (class 2606 OID 16437)
-- Name: idasis_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY asistencia
    ADD CONSTRAINT idasis_pk PRIMARY KEY (idasis);


--
-- TOC entry 1939 (class 2606 OID 16439)
-- Name: idfes_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diasfestivo
    ADD CONSTRAINT idfes_pk PRIMARY KEY (idfestivo);


--
-- TOC entry 1941 (class 2606 OID 16441)
-- Name: idhor_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT idhor_pk PRIMARY KEY (idhor);


--
-- TOC entry 1943 (class 2606 OID 16443)
-- Name: idhorper_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY horario_persona
    ADD CONSTRAINT idhorper_pk PRIMARY KEY (idhorper);


--
-- TOC entry 1949 (class 2606 OID 16445)
-- Name: idper_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY personal
    ADD CONSTRAINT idper_pk PRIMARY KEY (idper);


--
-- TOC entry 1945 (class 2606 OID 16447)
-- Name: idpermiso_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY permiso
    ADD CONSTRAINT idpermiso_pk PRIMARY KEY (idper);


--
-- TOC entry 1947 (class 2606 OID 16449)
-- Name: idperper_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY permiso_persona
    ADD CONSTRAINT idperper_pk PRIMARY KEY (idperper);


--
-- TOC entry 1951 (class 2606 OID 16451)
-- Name: idusuario_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT idusuario_pk PRIMARY KEY (idusuario);


--
-- TOC entry 1953 (class 2606 OID 16452)
-- Name: idhorper_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario_persona
    ADD CONSTRAINT idhorper_fk FOREIGN KEY (idhor) REFERENCES horario(idhor);


--
-- TOC entry 1957 (class 2606 OID 16457)
-- Name: idper_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT idper_fk FOREIGN KEY (idper) REFERENCES personal(idper);


--
-- TOC entry 1952 (class 2606 OID 16462)
-- Name: idper_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asistencia
    ADD CONSTRAINT idper_fk FOREIGN KEY (idper) REFERENCES personal(idper);


--
-- TOC entry 1954 (class 2606 OID 16467)
-- Name: idperhor_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario_persona
    ADD CONSTRAINT idperhor_fk FOREIGN KEY (idper) REFERENCES personal(idper);


--
-- TOC entry 1955 (class 2606 OID 16472)
-- Name: idpermiso_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso_persona
    ADD CONSTRAINT idpermiso_fk FOREIGN KEY (idpermiso) REFERENCES permiso(idper);


--
-- TOC entry 1956 (class 2606 OID 16477)
-- Name: idpersona_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso_persona
    ADD CONSTRAINT idpersona_fk FOREIGN KEY (idpersona) REFERENCES personal(idper);


--
-- TOC entry 2073 (class 0 OID 0)
-- Dependencies: 7
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2017-05-20 19:12:19 -04

--
-- PostgreSQL database dump complete
--

