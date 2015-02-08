--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.14
-- Dumped by pg_dump version 9.1.14
-- Started on 2015-02-03 22:28:37 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 177 (class 3079 OID 11645)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 1932 (class 0 OID 0)
-- Dependencies: 177
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 176 (class 1259 OID 35676)
-- Dependencies: 5
-- Name: asistencia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE asistencia (
    idasis integer NOT NULL,
    idper integer,
    hora time without time zone,
    fecha date
);


ALTER TABLE public.asistencia OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 35674)
-- Dependencies: 5 176
-- Name: asistencia_idasis_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE asistencia_idasis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.asistencia_idasis_seq OWNER TO postgres;

--
-- TOC entry 1933 (class 0 OID 0)
-- Dependencies: 175
-- Name: asistencia_idasis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE asistencia_idasis_seq OWNED BY asistencia.idasis;


--
-- TOC entry 170 (class 1259 OID 35540)
-- Dependencies: 5
-- Name: diasfestivo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diasfestivo (
    idfestivo integer NOT NULL,
    fecha date,
    descfest character varying
);


ALTER TABLE public.diasfestivo OWNER TO postgres;

--
-- TOC entry 1934 (class 0 OID 0)
-- Dependencies: 170
-- Name: COLUMN diasfestivo.descfest; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN diasfestivo.descfest IS 'nombre dle dia festivo';


--
-- TOC entry 169 (class 1259 OID 35538)
-- Dependencies: 170 5
-- Name: diasfestivo_idfestivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diasfestivo_idfestivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diasfestivo_idfestivo_seq OWNER TO postgres;

--
-- TOC entry 1935 (class 0 OID 0)
-- Dependencies: 169
-- Name: diasfestivo_idfestivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diasfestivo_idfestivo_seq OWNED BY diasfestivo.idfestivo;


--
-- TOC entry 164 (class 1259 OID 35490)
-- Dependencies: 5
-- Name: horario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE horario (
    idhor integer NOT NULL,
    horentrada time without time zone,
    horasalida time without time zone,
    descripcionhor character varying(100)
);


ALTER TABLE public.horario OWNER TO postgres;

--
-- TOC entry 1936 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN horario.horentrada; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN horario.horentrada IS 'hora de inicio manana';


--
-- TOC entry 1937 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN horario.horasalida; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN horario.horasalida IS 'hora de fin manana';


--
-- TOC entry 163 (class 1259 OID 35488)
-- Dependencies: 164 5
-- Name: horario_idhor_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE horario_idhor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.horario_idhor_seq OWNER TO postgres;

--
-- TOC entry 1938 (class 0 OID 0)
-- Dependencies: 163
-- Name: horario_idhor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE horario_idhor_seq OWNED BY horario.idhor;


--
-- TOC entry 172 (class 1259 OID 35551)
-- Dependencies: 5
-- Name: horario_persona; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE horario_persona (
    idhorper integer NOT NULL,
    idper integer,
    idhor integer
);


ALTER TABLE public.horario_persona OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 35549)
-- Dependencies: 5 172
-- Name: horario_persona_idhorper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE horario_persona_idhorper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.horario_persona_idhorper_seq OWNER TO postgres;

--
-- TOC entry 1939 (class 0 OID 0)
-- Dependencies: 171
-- Name: horario_persona_idhorper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE horario_persona_idhorper_seq OWNED BY horario_persona.idhorper;


--
-- TOC entry 166 (class 1259 OID 35514)
-- Dependencies: 5
-- Name: permiso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE permiso (
    idper integer NOT NULL,
    descper character varying(60)
);


ALTER TABLE public.permiso OWNER TO postgres;

--
-- TOC entry 1940 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN permiso.descper; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN permiso.descper IS 'descripcion permiso';


--
-- TOC entry 165 (class 1259 OID 35512)
-- Dependencies: 166 5
-- Name: permiso_idper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE permiso_idper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permiso_idper_seq OWNER TO postgres;

--
-- TOC entry 1941 (class 0 OID 0)
-- Dependencies: 165
-- Name: permiso_idper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE permiso_idper_seq OWNED BY permiso.idper;


--
-- TOC entry 168 (class 1259 OID 35522)
-- Dependencies: 5
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


ALTER TABLE public.permiso_persona OWNER TO postgres;

--
-- TOC entry 1942 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN permiso_persona.idperper; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN permiso_persona.idperper IS 'id permiso persona';


--
-- TOC entry 167 (class 1259 OID 35520)
-- Dependencies: 168 5
-- Name: permiso_persona_idperper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE permiso_persona_idperper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permiso_persona_idperper_seq OWNER TO postgres;

--
-- TOC entry 1943 (class 0 OID 0)
-- Dependencies: 167
-- Name: permiso_persona_idperper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE permiso_persona_idperper_seq OWNED BY permiso_persona.idperper;


--
-- TOC entry 162 (class 1259 OID 35482)
-- Dependencies: 5
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
    condicion character varying(50)
);


ALTER TABLE public.personal OWNER TO postgres;

--
-- TOC entry 161 (class 1259 OID 35480)
-- Dependencies: 162 5
-- Name: personal_idper_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE personal_idper_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_idper_seq OWNER TO postgres;

--
-- TOC entry 1944 (class 0 OID 0)
-- Dependencies: 161
-- Name: personal_idper_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE personal_idper_seq OWNED BY personal.idper;


--
-- TOC entry 174 (class 1259 OID 35586)
-- Dependencies: 5
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


ALTER TABLE public.usuario OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 35584)
-- Dependencies: 174 5
-- Name: usuario_idusuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuario_idusuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_idusuario_seq OWNER TO postgres;

--
-- TOC entry 1945 (class 0 OID 0)
-- Dependencies: 173
-- Name: usuario_idusuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuario_idusuario_seq OWNED BY usuario.idusuario;


--
-- TOC entry 1801 (class 2604 OID 35679)
-- Dependencies: 175 176 176
-- Name: idasis; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asistencia ALTER COLUMN idasis SET DEFAULT nextval('asistencia_idasis_seq'::regclass);


--
-- TOC entry 1798 (class 2604 OID 35543)
-- Dependencies: 170 169 170
-- Name: idfestivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diasfestivo ALTER COLUMN idfestivo SET DEFAULT nextval('diasfestivo_idfestivo_seq'::regclass);


--
-- TOC entry 1795 (class 2604 OID 35493)
-- Dependencies: 163 164 164
-- Name: idhor; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario ALTER COLUMN idhor SET DEFAULT nextval('horario_idhor_seq'::regclass);


--
-- TOC entry 1799 (class 2604 OID 35554)
-- Dependencies: 171 172 172
-- Name: idhorper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario_persona ALTER COLUMN idhorper SET DEFAULT nextval('horario_persona_idhorper_seq'::regclass);


--
-- TOC entry 1796 (class 2604 OID 35517)
-- Dependencies: 166 165 166
-- Name: idper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso ALTER COLUMN idper SET DEFAULT nextval('permiso_idper_seq'::regclass);


--
-- TOC entry 1797 (class 2604 OID 35525)
-- Dependencies: 168 167 168
-- Name: idperper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso_persona ALTER COLUMN idperper SET DEFAULT nextval('permiso_persona_idperper_seq'::regclass);


--
-- TOC entry 1794 (class 2604 OID 35485)
-- Dependencies: 162 161 162
-- Name: idper; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY personal ALTER COLUMN idper SET DEFAULT nextval('personal_idper_seq'::regclass);


--
-- TOC entry 1800 (class 2604 OID 35589)
-- Dependencies: 173 174 174
-- Name: idusuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario ALTER COLUMN idusuario SET DEFAULT nextval('usuario_idusuario_seq'::regclass);


--
-- TOC entry 1817 (class 2606 OID 35681)
-- Dependencies: 176 176 1926
-- Name: idasis_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY asistencia
    ADD CONSTRAINT idasis_pk PRIMARY KEY (idasis);


--
-- TOC entry 1811 (class 2606 OID 35548)
-- Dependencies: 170 170 1926
-- Name: idfes_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diasfestivo
    ADD CONSTRAINT idfes_pk PRIMARY KEY (idfestivo);


--
-- TOC entry 1805 (class 2606 OID 35495)
-- Dependencies: 164 164 1926
-- Name: idhor_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY horario
    ADD CONSTRAINT idhor_pk PRIMARY KEY (idhor);


--
-- TOC entry 1813 (class 2606 OID 35556)
-- Dependencies: 172 172 1926
-- Name: idhorper_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY horario_persona
    ADD CONSTRAINT idhorper_pk PRIMARY KEY (idhorper);


--
-- TOC entry 1803 (class 2606 OID 35487)
-- Dependencies: 162 162 1926
-- Name: idper_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY personal
    ADD CONSTRAINT idper_pk PRIMARY KEY (idper);


--
-- TOC entry 1807 (class 2606 OID 35519)
-- Dependencies: 166 166 1926
-- Name: idpermiso_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY permiso
    ADD CONSTRAINT idpermiso_pk PRIMARY KEY (idper);


--
-- TOC entry 1809 (class 2606 OID 35527)
-- Dependencies: 168 168 1926
-- Name: idperper_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY permiso_persona
    ADD CONSTRAINT idperper_pk PRIMARY KEY (idperper);


--
-- TOC entry 1815 (class 2606 OID 35591)
-- Dependencies: 174 174 1926
-- Name: idusuario_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT idusuario_pk PRIMARY KEY (idusuario);


--
-- TOC entry 1820 (class 2606 OID 35597)
-- Dependencies: 1804 172 164 1926
-- Name: idhorper_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario_persona
    ADD CONSTRAINT idhorper_fk FOREIGN KEY (idhor) REFERENCES horario(idhor);


--
-- TOC entry 1822 (class 2606 OID 35706)
-- Dependencies: 1802 162 174 1926
-- Name: idper_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT idper_fk FOREIGN KEY (idper) REFERENCES personal(idper);


--
-- TOC entry 1823 (class 2606 OID 35740)
-- Dependencies: 176 1802 162 1926
-- Name: idper_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asistencia
    ADD CONSTRAINT idper_fk FOREIGN KEY (idper) REFERENCES personal(idper);


--
-- TOC entry 1821 (class 2606 OID 35602)
-- Dependencies: 172 1802 162 1926
-- Name: idperhor_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY horario_persona
    ADD CONSTRAINT idperhor_fk FOREIGN KEY (idper) REFERENCES personal(idper);


--
-- TOC entry 1818 (class 2606 OID 35719)
-- Dependencies: 168 166 1806 1926
-- Name: idpermiso_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso_persona
    ADD CONSTRAINT idpermiso_fk FOREIGN KEY (idpermiso) REFERENCES permiso(idper);


--
-- TOC entry 1819 (class 2606 OID 35724)
-- Dependencies: 1802 168 162 1926
-- Name: idpersona_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permiso_persona
    ADD CONSTRAINT idpersona_fk FOREIGN KEY (idpersona) REFERENCES personal(idper);


--
-- TOC entry 1931 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-02-03 22:28:37 VET

--
-- PostgreSQL database dump complete
--

