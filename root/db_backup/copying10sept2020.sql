--
-- PostgreSQL database dump
--

-- Dumped from database version 11.8
-- Dumped by pg_dump version 11.8

-- Started on 2020-09-10 12:55:16

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 196 (class 1259 OID 17118)
-- Name: document; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.document (
    document_id integer NOT NULL,
    application_id character varying(40),
    document_path character varying(200),
    create_at timestamp with time zone,
    delete_at timestamp with time zone,
    created_by character varying(40) NOT NULL,
    update_at timestamp with time zone
);


ALTER TABLE public.document OWNER TO postgres;

--
-- TOC entry 3099 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.document_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.document_id IS 'Document ID';


--
-- TOC entry 3100 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.application_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.application_id IS 'To indicate, document of which application, application_id referenced from application table, works as foreign key.';


--
-- TOC entry 3101 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.document_path; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.document_path IS 'file path of the document';


--
-- TOC entry 3102 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.create_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.create_at IS 'date and time of creating document';


--
-- TOC entry 3103 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.delete_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.delete_at IS 'date and time of deleting document';


--
-- TOC entry 3104 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.created_by IS 'This is the user id  to indicate who created the document. ';


--
-- TOC entry 3105 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN document.update_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.document.update_at IS 'last updated timestamp';


--
-- TOC entry 197 (class 1259 OID 17121)
-- Name: Document_document_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Document_document_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Document_document_id_seq" OWNER TO postgres;

--
-- TOC entry 3106 (class 0 OID 0)
-- Dependencies: 197
-- Name: Document_document_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Document_document_id_seq" OWNED BY public.document.document_id;


--
-- TOC entry 198 (class 1259 OID 17123)
-- Name: Process_Tasks_Mapping_process_tasks_mapping_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Process_Tasks_Mapping_process_tasks_mapping_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public."Process_Tasks_Mapping_process_tasks_mapping_id_seq" OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 17125)
-- Name: Tasks_Role_Mapping_tasks_role_mapping_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Tasks_Role_Mapping_tasks_role_mapping_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public."Tasks_Role_Mapping_tasks_role_mapping_id_seq" OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 17127)
-- Name: application; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.application (
    application_id character varying(40) NOT NULL,
    case_type_id integer,
    case_no integer,
    case_year integer,
    petitioner character varying(300),
    respondent character varying(300),
    copy_type_id integer,
    order_date date,
    create_at timestamp without time zone,
    user_id character varying(40),
    is_order character(1),
    case_no_reference integer,
    case_type_reference integer,
    case_year_reference integer,
    is_third_party character(1),
    certificate_type_id integer,
    is_offline character(1)
);


ALTER TABLE public.application OWNER TO postgres;

--
-- TOC entry 3107 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.application_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.application_id IS 'this is primary key';


--
-- TOC entry 3108 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.case_type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.case_type_id IS 'case type
';


--
-- TOC entry 3109 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.petitioner; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.petitioner IS 'Appellant or Petitioner';


--
-- TOC entry 3110 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.respondent; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.respondent IS 'Respondent or Opposite Party';


--
-- TOC entry 3111 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.copy_type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.copy_type_id IS 'Certificate type whether Order Copy or Other';


--
-- TOC entry 3112 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.order_date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.order_date IS 'Date of Order or Disclosure';


--
-- TOC entry 3113 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.create_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.create_at IS 'Date of submission of the application';


--
-- TOC entry 3114 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.user_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.user_id IS 'The user who submits application';


--
-- TOC entry 3115 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.is_order; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.is_order IS 'whether the application is for Order Copy or not';


--
-- TOC entry 3116 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.case_no_reference; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.case_no_reference IS 'Refer to which case no';


--
-- TOC entry 3117 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.case_type_reference; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.case_type_reference IS 'Refer to which case type';


--
-- TOC entry 3118 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.case_year_reference; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.case_year_reference IS 'refer to which case year';


--
-- TOC entry 3119 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.is_third_party; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.is_third_party IS 'to check whether applicant is third party ';


--
-- TOC entry 3120 (class 0 OID 0)
-- Dependencies: 200
-- Name: COLUMN application.is_offline; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application.is_offline IS 'Whether application is submitted in online or offline mode.';


--
-- TOC entry 201 (class 1259 OID 17133)
-- Name: certificate_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.certificate_type (
    certificate_type_id integer NOT NULL,
    name character varying(30)
);


ALTER TABLE public.certificate_type OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 17136)
-- Name: application_for_application_for_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.application_for_application_for_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.application_for_application_for_id_seq OWNER TO postgres;

--
-- TOC entry 3121 (class 0 OID 0)
-- Dependencies: 202
-- Name: application_for_application_for_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.application_for_application_for_id_seq OWNED BY public.certificate_type.certificate_type_id;


--
-- TOC entry 203 (class 1259 OID 17138)
-- Name: application_tasks_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.application_tasks_log (
    application_tasks_log_id character varying(40) NOT NULL,
    application_id character varying(40),
    user_id character varying(64),
    action_date timestamp with time zone DEFAULT now(),
    action_name character varying(30),
    tasks_id integer DEFAULT '-1'::integer,
    remark character varying(300) DEFAULT NULL::character varying,
    process_id integer,
    source_ip character varying(30),
    role_id integer,
    next_tasks_id integer
);


ALTER TABLE public.application_tasks_log OWNER TO postgres;

--
-- TOC entry 3122 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN application_tasks_log.role_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application_tasks_log.role_id IS 'Just to keep track of which user role had commited this task. since user role of a user can be changed from time to time as and when required, or the user role may be removed from granting access to access a task. But the user id will remain same.';


--
-- TOC entry 204 (class 1259 OID 17147)
-- Name: case_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.case_type (
    case_type_id smallint DEFAULT 0 NOT NULL,
    type_name character varying(50) DEFAULT NULL::character varying,
    ltype_name character varying(50) DEFAULT NULL::character varying,
    full_form character varying(100) DEFAULT NULL::character varying,
    lfull_form character varying(100) DEFAULT NULL::character varying,
    type_flag integer DEFAULT 1 NOT NULL,
    filing_no integer DEFAULT 0 NOT NULL,
    filing_year smallint DEFAULT 0 NOT NULL,
    reg_no integer DEFAULT 0 NOT NULL,
    reg_year smallint DEFAULT 0 NOT NULL,
    display character(1) DEFAULT 'Y'::bpchar NOT NULL,
    petitioner character varying(99) DEFAULT NULL::character varying,
    respondent character varying(99) DEFAULT NULL::character varying,
    lpetitioner character varying(99) DEFAULT NULL::character varying,
    lrespondent character varying(99) DEFAULT NULL::character varying,
    res_disp smallint DEFAULT 0 NOT NULL,
    case_priority smallint DEFAULT 0 NOT NULL,
    national_code bigint DEFAULT 0 NOT NULL,
    macp character(1) DEFAULT 'N'::bpchar NOT NULL,
    stage_id text,
    matter_type integer DEFAULT 0,
    cavreg_no integer DEFAULT 0 NOT NULL,
    cavreg_year smallint DEFAULT 0 NOT NULL,
    direct_reg character(1) DEFAULT 'N'::bpchar NOT NULL,
    cavfil_no integer DEFAULT 0 NOT NULL,
    cavfil_year smallint DEFAULT 0 NOT NULL,
    ia_filing_no integer DEFAULT 0 NOT NULL,
    ia_filing_year smallint DEFAULT 0 NOT NULL,
    ia_reg_no integer DEFAULT 0 NOT NULL,
    ia_reg_year smallint DEFAULT 0 NOT NULL,
    tag_courts character varying(1000),
    amd character(1),
    create_modify timestamp without time zone DEFAULT now(),
    est_code_src character(6) DEFAULT 'xxxxxx'::bpchar NOT NULL,
    reasonable_dispose text
);


ALTER TABLE public.case_type OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 17184)
-- Name: copy_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.copy_type (
    copy_type_id integer NOT NULL,
    copy_name character varying(30)
);


ALTER TABLE public.copy_type OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 17187)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id character varying(40) NOT NULL,
    full_name character varying(300),
    email character varying(50),
    phone_number character varying(30),
    role_id integer NOT NULL,
    user_password character varying(64) NOT NULL,
    verify boolean DEFAULT false,
    create_at timestamp with time zone DEFAULT now() NOT NULL,
    update_at timestamp with time zone,
    delete_at timestamp with time zone,
    profile_image character varying(300),
    aadhaar character(12) DEFAULT NULL::character varying,
    update_by character varying(40)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 3123 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.full_name; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.full_name IS 'User Full Name';


--
-- TOC entry 3124 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.phone_number; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.phone_number IS 'Phone number of the user';


--
-- TOC entry 3125 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.user_password; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.user_password IS 'hashed password';


--
-- TOC entry 3126 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.verify; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.verify IS 'Whether user is verified or not';


--
-- TOC entry 3127 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.create_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.create_at IS 'The time when user is registered';


--
-- TOC entry 3128 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.update_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.update_at IS 'The last time when user details is updated';


--
-- TOC entry 3129 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.delete_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.delete_at IS 'The time when user account is deleted';


--
-- TOC entry 3130 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.aadhaar; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.aadhaar IS 'for future reference';


--
-- TOC entry 3131 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN users.update_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.update_by IS 'the user id who update user details last time. update can be done by the user himself or by the admin';


--
-- TOC entry 207 (class 1259 OID 17196)
-- Name: application_tasks_log_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.application_tasks_log_view AS
 SELECT a.application_id,
    a.certificate_type_id,
    a.case_type_id,
    cert.name AS certificate_type_name,
    a.case_no,
    a.case_year,
    a.petitioner,
    a.respondent,
    a.copy_type_id,
    a.order_date,
    a.create_at,
    a.user_id,
    a.is_order,
    a.case_no_reference,
    a.case_type_reference,
    a.case_year_reference,
    a.is_third_party,
    a.is_offline,
    ct.copy_name,
    atl.application_tasks_log_id,
    atl.user_id AS action_user_id,
    atl.action_date,
    atl.action_name,
    atl.remark,
    atl.role_id,
    atl.process_id,
    atl.tasks_id,
    atl.next_tasks_id,
    u.full_name AS action_user_full_name,
    u2.full_name AS applicant_name,
    case_type.type_name AS case_type_name,
    case_type.full_form AS case_type_full_form
   FROM ((((((public.application a
     JOIN public.application_tasks_log atl ON (((a.application_id)::text = (atl.application_id)::text)))
     JOIN public.copy_type ct ON ((a.copy_type_id = ct.copy_type_id)))
     JOIN public.users u ON (((atl.user_id)::text = (u.user_id)::text)))
     LEFT JOIN public.case_type ON ((a.case_type_id = case_type.case_type_id)))
     JOIN public.users u2 ON (((a.user_id)::text = (u2.user_id)::text)))
     LEFT JOIN public.certificate_type cert ON ((a.certificate_type_id = cert.certificate_type_id)));


ALTER TABLE public.application_tasks_log_view OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 17201)
-- Name: casebody; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.casebody (
    casebody_id integer NOT NULL,
    case_type_id integer,
    case_number integer,
    case_year integer,
    document_path character varying(255) NOT NULL,
    created_at timestamp with time zone,
    created_by character varying(40)
);


ALTER TABLE public.casebody OWNER TO postgres;

--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 208
-- Name: COLUMN casebody.created_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.casebody.created_at IS 'When this row is created';


--
-- TOC entry 209 (class 1259 OID 17204)
-- Name: case_body_case_body_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.case_body_case_body_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.case_body_case_body_id_seq OWNER TO postgres;

--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 209
-- Name: case_body_case_body_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.case_body_case_body_id_seq OWNED BY public.casebody.casebody_id;


--
-- TOC entry 210 (class 1259 OID 17206)
-- Name: latest_application_tasks_log_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.latest_application_tasks_log_view AS
 SELECT atl.application_id,
    atl.certificate_type_id,
    atl.case_type_id,
    atl.certificate_type_name,
    atl.case_no,
    atl.case_year,
    atl.petitioner,
    atl.respondent,
    atl.copy_type_id,
    atl.order_date,
    atl.create_at,
    atl.user_id,
    atl.is_order,
    atl.case_no_reference,
    atl.case_type_reference,
    atl.case_year_reference,
    atl.is_third_party,
    atl.is_offline,
    atl.copy_name,
    atl.application_tasks_log_id,
    atl.action_user_id,
    atl.action_date,
    atl.action_name,
    atl.remark,
    atl.role_id,
    atl.process_id,
    atl.tasks_id,
    atl.next_tasks_id,
    atl.action_user_full_name,
    atl.applicant_name,
    atl.case_type_name,
    atl.case_type_full_form
   FROM public.application_tasks_log_view atl
  WHERE (atl.action_date = ( SELECT max(atl2.action_date) AS max
           FROM public.application_tasks_log atl2
          WHERE ((atl.application_id)::text = (atl2.application_id)::text)));


ALTER TABLE public.latest_application_tasks_log_view OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 17211)
-- Name: logins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.logins (
    login_id character varying(60) NOT NULL,
    login_time timestamp with time zone NOT NULL,
    logout_time timestamp with time zone,
    expiry timestamp with time zone,
    source_ip character varying(30),
    device character varying(250),
    user_id character varying(40)
);


ALTER TABLE public.logins OWNER TO postgres;

--
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.login_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.login_id IS 'user login id';


--
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.login_time; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.login_time IS 'the time when user logs in';


--
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.logout_time; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.logout_time IS 'time when user logs out';


--
-- TOC entry 3137 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.expiry; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.expiry IS 'date and time of expiry of the login session';


--
-- TOC entry 3138 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.source_ip; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.source_ip IS 'login from which computer';


--
-- TOC entry 3139 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.device; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.device IS 'name of the device or user agent through which login takes place';


--
-- TOC entry 3140 (class 0 OID 0)
-- Dependencies: 211
-- Name: COLUMN logins.user_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.logins.user_id IS 'To indicate whose login';


--
-- TOC entry 212 (class 1259 OID 17214)
-- Name: menu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu (
    menu_id integer NOT NULL,
    menu_name character varying(90),
    link character varying(100),
    parent_menu_id integer,
    sequence integer
);


ALTER TABLE public.menu OWNER TO postgres;

--
-- TOC entry 3141 (class 0 OID 0)
-- Dependencies: 212
-- Name: COLUMN menu.sequence; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.menu.sequence IS 'sequence for displaying menu';


--
-- TOC entry 213 (class 1259 OID 17217)
-- Name: menu_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menu_menu_id_seq OWNER TO postgres;

--
-- TOC entry 3142 (class 0 OID 0)
-- Dependencies: 213
-- Name: menu_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menu_menu_id_seq OWNED BY public.menu.menu_id;


--
-- TOC entry 214 (class 1259 OID 17219)
-- Name: menu_role_mapping; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_role_mapping (
    menu_id integer,
    role_id integer,
    menu_role_mapping_id integer DEFAULT nextval(('public.menu_role_mapping_menu_role_mapping_id_seq'::text)::regclass) NOT NULL
);


ALTER TABLE public.menu_role_mapping OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 17223)
-- Name: menu_role_mapping_menu_role_mapping_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menu_role_mapping_menu_role_mapping_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.menu_role_mapping_menu_role_mapping_id_seq OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 17225)
-- Name: offline_application; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.offline_application (
    application_id character varying(40) NOT NULL,
    applicant_name character varying(225) NOT NULL,
    offline_application_id integer NOT NULL,
    aadhaar character(12) NOT NULL
);


ALTER TABLE public.offline_application OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 17228)
-- Name: offline_payment_receipt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.offline_payment_receipt (
    offline_payment_receipt_id integer NOT NULL,
    receipt_path character varying(255),
    application_id character varying(40),
    created_at timestamp with time zone
);


ALTER TABLE public.offline_payment_receipt OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 17231)
-- Name: payable_amount; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payable_amount (
    payable_amount_id integer NOT NULL,
    purpose character varying(255),
    amount numeric(18,0)
);


ALTER TABLE public.payable_amount OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 17234)
-- Name: payable_amount_payable_amount_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payable_amount_payable_amount_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.payable_amount_payable_amount_id_seq OWNER TO postgres;

--
-- TOC entry 3143 (class 0 OID 0)
-- Dependencies: 219
-- Name: payable_amount_payable_amount_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payable_amount_payable_amount_id_seq OWNED BY public.payable_amount.payable_amount_id;


--
-- TOC entry 220 (class 1259 OID 17236)
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    payments_id integer NOT NULL,
    payment_type character varying(255),
    amount numeric(20,0),
    purpose character varying(255),
    application_id character varying(40),
    transaction_id character varying(30) NOT NULL,
    status character varying(30),
    created_at timestamp with time zone,
    payment_date character varying(255)
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- TOC entry 3144 (class 0 OID 0)
-- Dependencies: 220
-- Name: COLUMN payments.payment_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.payments.payment_type IS 'Either offline or online';


--
-- TOC entry 3145 (class 0 OID 0)
-- Dependencies: 220
-- Name: COLUMN payments.transaction_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.payments.transaction_id IS 'Transaction ID from payment gateway';


--
-- TOC entry 3146 (class 0 OID 0)
-- Dependencies: 220
-- Name: COLUMN payments.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.payments.status IS 'whether failed or success in transaction';


--
-- TOC entry 3147 (class 0 OID 0)
-- Dependencies: 220
-- Name: COLUMN payments.created_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.payments.created_at IS 'date of creating record';


--
-- TOC entry 221 (class 1259 OID 17242)
-- Name: payments_payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payments_payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.payments_payments_id_seq OWNER TO postgres;

--
-- TOC entry 3148 (class 0 OID 0)
-- Dependencies: 221
-- Name: payments_payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payments_payments_id_seq OWNED BY public.payments.payments_id;


--
-- TOC entry 222 (class 1259 OID 17244)
-- Name: process; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.process (
    process_id integer NOT NULL,
    process_name character varying(50) NOT NULL,
    process_description character varying(500),
    number_of_role integer
);


ALTER TABLE public.process OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 17250)
-- Name: process_process_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.process_process_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.process_process_id_seq OWNER TO postgres;

--
-- TOC entry 3149 (class 0 OID 0)
-- Dependencies: 223
-- Name: process_process_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.process_process_id_seq OWNED BY public.process.process_id;


--
-- TOC entry 224 (class 1259 OID 17252)
-- Name: process_role_map_process_role_map_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.process_role_map_process_role_map_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.process_role_map_process_role_map_id_seq OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 17254)
-- Name: process_tasks_mapping; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.process_tasks_mapping (
    process_tasks_mapping_id integer DEFAULT nextval(('public."Process_Tasks_Mapping_process_tasks_mapping_id_seq"'::text)::regclass) NOT NULL,
    process_id integer,
    tasks_id integer,
    priority_level integer,
    is_enabled character(1)
);


ALTER TABLE public.process_tasks_mapping OWNER TO postgres;

--
-- TOC entry 3150 (class 0 OID 0)
-- Dependencies: 225
-- Name: COLUMN process_tasks_mapping.process_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.process_tasks_mapping.process_id IS 'ID of a process';


--
-- TOC entry 3151 (class 0 OID 0)
-- Dependencies: 225
-- Name: COLUMN process_tasks_mapping.tasks_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.process_tasks_mapping.tasks_id IS 'A process can have many tasks and a task can also be included in another task. So the process and task are in many to many relationship.';


--
-- TOC entry 3152 (class 0 OID 0)
-- Dependencies: 225
-- Name: COLUMN process_tasks_mapping.priority_level; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.process_tasks_mapping.priority_level IS 'To indicate wich task will be performed first, second and third successively in the current process and task mapping.';


--
-- TOC entry 3153 (class 0 OID 0)
-- Dependencies: 225
-- Name: COLUMN process_tasks_mapping.is_enabled; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.process_tasks_mapping.is_enabled IS 'Whether the mapping is enabled or not';


--
-- TOC entry 226 (class 1259 OID 17258)
-- Name: tasks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tasks (
    tasks_id integer NOT NULL,
    tasks_name character varying(255),
    tasks_description character varying(255),
    create_at timestamp with time zone,
    update_at timestamp with time zone,
    delete_at timestamp with time zone,
    user_id character varying(40)
);


ALTER TABLE public.tasks OWNER TO postgres;

--
-- TOC entry 3154 (class 0 OID 0)
-- Dependencies: 226
-- Name: COLUMN tasks.user_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.tasks.user_id IS 'the user who either create task or update the task for the last time.';


--
-- TOC entry 227 (class 1259 OID 17264)
-- Name: process_tasks_mapping_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.process_tasks_mapping_view AS
 SELECT ptm1.process_tasks_mapping_id,
    ptm1.process_id,
    ptm1.tasks_id,
    ptm1.priority_level,
    ptm1.is_enabled,
    ptm1.tasks_name,
    ptm1.tasks_description,
    ptm2.tasks_id AS prev_tasks_id,
    ptm2.tasks_name AS prev_tasks_name,
    ptm3.tasks_id AS next_tasks_id,
    ptm3.tasks_name AS next_tasks_name
   FROM ((( SELECT process_tasks_mapping.process_tasks_mapping_id,
            process_tasks_mapping.process_id,
            process_tasks_mapping.tasks_id,
            process_tasks_mapping.priority_level,
            process_tasks_mapping.is_enabled,
            tasks.tasks_name,
            tasks.tasks_description
           FROM public.process_tasks_mapping,
            public.tasks
          WHERE (process_tasks_mapping.tasks_id = tasks.tasks_id)) ptm1
     LEFT JOIN ( SELECT process_tasks_mapping.process_tasks_mapping_id,
            process_tasks_mapping.process_id,
            process_tasks_mapping.tasks_id,
            process_tasks_mapping.priority_level,
            process_tasks_mapping.is_enabled,
            tasks.tasks_name
           FROM public.process_tasks_mapping,
            public.tasks
          WHERE (process_tasks_mapping.tasks_id = tasks.tasks_id)) ptm2 ON ((((ptm1.priority_level - 1) = ptm2.priority_level) AND (ptm1.process_id = ptm2.process_id))))
     LEFT JOIN ( SELECT process_tasks_mapping.process_tasks_mapping_id,
            process_tasks_mapping.process_id,
            process_tasks_mapping.tasks_id,
            process_tasks_mapping.priority_level,
            process_tasks_mapping.is_enabled,
            tasks.tasks_name
           FROM public.process_tasks_mapping,
            public.tasks
          WHERE (process_tasks_mapping.tasks_id = tasks.tasks_id)) ptm3 ON ((((ptm1.priority_level + 1) = ptm3.priority_level) AND (ptm1.process_id = ptm3.process_id))))
  ORDER BY ptm1.process_id, ptm1.priority_level;


ALTER TABLE public.process_tasks_mapping_view OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 17269)
-- Name: role; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role (
    role_id integer DEFAULT nextval(('public.roles_role_id_seq'::text)::regclass) NOT NULL,
    role_name character varying(255)
);


ALTER TABLE public.role OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 17273)
-- Name: roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.roles_role_id_seq OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 17275)
-- Name: status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.status (
    status_id integer NOT NULL,
    description character varying(255),
    created_at timestamp with time zone DEFAULT ('now'::text)::date NOT NULL,
    updated_at timestamp with time zone,
    deleted_at timestamp with time zone,
    application_id character varying(50) NOT NULL,
    user_id character varying(50) NOT NULL
);


ALTER TABLE public.status OWNER TO postgres;

--
-- TOC entry 3155 (class 0 OID 0)
-- Dependencies: 230
-- Name: COLUMN status.description; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.status.description IS 'Description about the status of an application, whether completed or still processing';


--
-- TOC entry 3156 (class 0 OID 0)
-- Dependencies: 230
-- Name: COLUMN status.created_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.status.created_at IS 'Date and time on which status is created';


--
-- TOC entry 3157 (class 0 OID 0)
-- Dependencies: 230
-- Name: COLUMN status.updated_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.status.updated_at IS 'date and time on which status is updated';


--
-- TOC entry 3158 (class 0 OID 0)
-- Dependencies: 230
-- Name: COLUMN status.deleted_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.status.deleted_at IS 'Date and time on which status is deleted';


--
-- TOC entry 3159 (class 0 OID 0)
-- Dependencies: 230
-- Name: COLUMN status.application_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.status.application_id IS 'to indicate status of which application';


--
-- TOC entry 3160 (class 0 OID 0)
-- Dependencies: 230
-- Name: COLUMN status.user_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.status.user_id IS 'To indicate who create the status';


--
-- TOC entry 231 (class 1259 OID 17279)
-- Name: status_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.status_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.status_status_id_seq OWNER TO postgres;

--
-- TOC entry 3161 (class 0 OID 0)
-- Dependencies: 231
-- Name: status_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.status_status_id_seq OWNED BY public.status.status_id;


--
-- TOC entry 232 (class 1259 OID 17281)
-- Name: tasks_role_mapping; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tasks_role_mapping (
    tasks_role_mapping_id integer DEFAULT nextval(('public."Tasks_Role_Mapping_tasks_role_mapping_id_seq"'::text)::regclass) NOT NULL,
    tasks_id integer,
    role_id integer
);


ALTER TABLE public.tasks_role_mapping OWNER TO postgres;

--
-- TOC entry 3162 (class 0 OID 0)
-- Dependencies: 232
-- Name: TABLE tasks_role_mapping; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.tasks_role_mapping IS 'This table is mainly to show which user roles are granted for access to a specific particular task. A task can be done by many kinds of users.';


--
-- TOC entry 233 (class 1259 OID 17285)
-- Name: third_party_applicant_reasons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.third_party_applicant_reasons (
    third_party_application_reasons_id integer NOT NULL,
    application_id character varying(50) NOT NULL,
    reason character varying(255) NOT NULL
);


ALTER TABLE public.third_party_applicant_reasons OWNER TO postgres;

--
-- TOC entry 3163 (class 0 OID 0)
-- Dependencies: 233
-- Name: TABLE third_party_applicant_reasons; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.third_party_applicant_reasons IS 'This table records the reasons submitted by third party in applying for certify copy';


--
-- TOC entry 234 (class 1259 OID 17288)
-- Name: third_party_application_reaso_third_party_application_reaso_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.third_party_application_reaso_third_party_application_reaso_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.third_party_application_reaso_third_party_application_reaso_seq OWNER TO postgres;

--
-- TOC entry 3164 (class 0 OID 0)
-- Dependencies: 234
-- Name: third_party_application_reaso_third_party_application_reaso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.third_party_application_reaso_third_party_application_reaso_seq OWNED BY public.third_party_applicant_reasons.third_party_application_reasons_id;


--
-- TOC entry 235 (class 1259 OID 17290)
-- Name: third_party_reasons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.third_party_reasons (
    third_party_reasons_id integer NOT NULL,
    reasons character varying(255) NOT NULL
);


ALTER TABLE public.third_party_reasons OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 17293)
-- Name: third_party_reasons_third_party_reasons_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.third_party_reasons_third_party_reasons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.third_party_reasons_third_party_reasons_id_seq OWNER TO postgres;

--
-- TOC entry 3165 (class 0 OID 0)
-- Dependencies: 236
-- Name: third_party_reasons_third_party_reasons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.third_party_reasons_third_party_reasons_id_seq OWNED BY public.third_party_reasons.third_party_reasons_id;


--
-- TOC entry 237 (class 1259 OID 17295)
-- Name: user_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.user_view AS
 SELECT u.user_id,
    u.full_name,
    u.email,
    u.phone_number,
    u.role_id,
    u.user_password,
    u.verify,
    u.create_at,
    u.update_at,
    u.delete_at,
    u.profile_image,
    u.aadhaar,
    u.update_by,
    r.role_name
   FROM (public.users u
     LEFT JOIN public.role r ON ((u.role_id = r.role_id)));


ALTER TABLE public.user_view OWNER TO postgres;

--
-- TOC entry 2863 (class 2604 OID 17299)
-- Name: casebody casebody_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.casebody ALTER COLUMN casebody_id SET DEFAULT nextval('public.case_body_case_body_id_seq'::regclass);


--
-- TOC entry 2825 (class 2604 OID 17300)
-- Name: certificate_type certificate_type_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.certificate_type ALTER COLUMN certificate_type_id SET DEFAULT nextval('public.application_for_application_for_id_seq'::regclass);


--
-- TOC entry 2824 (class 2604 OID 17301)
-- Name: document document_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.document ALTER COLUMN document_id SET DEFAULT nextval('public."Document_document_id_seq"'::regclass);


--
-- TOC entry 2864 (class 2604 OID 17302)
-- Name: menu menu_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu ALTER COLUMN menu_id SET DEFAULT nextval('public.menu_menu_id_seq'::regclass);


--
-- TOC entry 2866 (class 2604 OID 17303)
-- Name: payable_amount payable_amount_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payable_amount ALTER COLUMN payable_amount_id SET DEFAULT nextval('public.payable_amount_payable_amount_id_seq'::regclass);


--
-- TOC entry 2867 (class 2604 OID 17304)
-- Name: payments payments_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments ALTER COLUMN payments_id SET DEFAULT nextval('public.payments_payments_id_seq'::regclass);


--
-- TOC entry 2868 (class 2604 OID 17305)
-- Name: process process_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.process ALTER COLUMN process_id SET DEFAULT nextval('public.process_process_id_seq'::regclass);


--
-- TOC entry 2872 (class 2604 OID 17306)
-- Name: status status_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.status ALTER COLUMN status_id SET DEFAULT nextval('public.status_status_id_seq'::regclass);


--
-- TOC entry 2874 (class 2604 OID 17307)
-- Name: third_party_applicant_reasons third_party_application_reasons_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.third_party_applicant_reasons ALTER COLUMN third_party_application_reasons_id SET DEFAULT nextval('public.third_party_application_reaso_third_party_application_reaso_seq'::regclass);


--
-- TOC entry 2875 (class 2604 OID 17308)
-- Name: third_party_reasons third_party_reasons_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.third_party_reasons ALTER COLUMN third_party_reasons_id SET DEFAULT nextval('public.third_party_reasons_third_party_reasons_id_seq'::regclass);


--
-- TOC entry 3060 (class 0 OID 17127)
-- Dependencies: 200
-- Data for Name: application; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.application (application_id, case_type_id, case_no, case_year, petitioner, respondent, copy_type_id, order_date, create_at, user_id, is_order, case_no_reference, case_type_reference, case_year_reference, is_third_party, certificate_type_id, is_offline) FROM stdin;
1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	106	7	2011	Yaikhomba	Manithoiba	2	2020-02-01	2020-02-04 12:50:58	c039de78-d396-4156-94ef-11f67c5991d9	n	-1	-1	-1	y	1	n
14750714-5dc6-4e12-9240-dca5c378b3bd	51	6	2010	Tombi	Chaobi	1	2020-02-01	2020-02-04 20:06:22	c039de78-d396-4156-94ef-11f67c5991d9	y	-1	-1	-1	n	3	n
acd8118b-d4af-4bd4-bacb-f9d708c0afdc	133	36	2011	Tonny	Kenny	4	2020-02-01	2020-02-04 20:31:47	c039de78-d396-4156-94ef-11f67c5991d9	n	-1	-1	-1	y	3	n
63ed9704-831a-4aea-9799-545e454e4a5f	110	32	2013	Tonny	Manithoiba	5	2020-01-02	2020-02-06 12:13:49	c039de78-d396-4156-94ef-11f67c5991d9	n	-1	-1	-1	n	2	n
3efce6ec-2ab7-45c9-b361-ecc560cc1174	110	36	2011	Nganthoiba	Manithoiba	4	2020-02-01	2020-02-06 12:37:46	f238775f-6e77-4df4-871d-7fb6fe8112b9	n	-1	-1	-1	n	3	n
aca15268-ceec-48f7-9921-2f32cb69e6ca	8	32	2011	Tonny	Kenny	3	2020-02-01	2020-02-06 12:38:58	f238775f-6e77-4df4-871d-7fb6fe8112b9	n	-1	-1	-1	y	3	n
94446f26-5a0c-4979-bbde-8a16ff936640	102	32	2014	Alex	Bobby	1	2020-02-01	2020-02-06 12:39:40	f238775f-6e77-4df4-871d-7fb6fe8112b9	y	-1	-1	-1	y	4	n
1993c5a7-851c-4d76-863e-7986aa17e035	106	36	2011	tomba	Blex	1	2020-02-01	2020-02-06 12:47:34	f238775f-6e77-4df4-871d-7fb6fe8112b9	y	25	105	2013	n	4	n
af2fbbea-4f9f-4ec3-a53b-558215f67e18	8	42	2016	Monika	Manithoiba	2	2020-02-01	2020-02-06 12:52:33	f238775f-6e77-4df4-871d-7fb6fe8112b9	n	-1	-1	-1	n	2	n
f955c735-4183-4b79-8ed3-c4dbd0e07de1	8	36	2019	Tonny	Chinglemba	1	2020-02-02	2020-02-06 12:55:43	f238775f-6e77-4df4-871d-7fb6fe8112b9	y	-1	-1	-1	n	1	n
83e41810-e4da-41c9-b040-fac31b87057b	106	42	2014	Tonny	Kenny	1	2020-02-02	2020-02-06 13:11:20	c039de78-d396-4156-94ef-11f67c5991d9	y	3	102	2013	n	3	n
68a4fbfd-a174-4171-a059-7f9624259753	8	36	2014	Tonny	Huranba	1	2020-02-02	2020-02-06 13:12:10	c039de78-d396-4156-94ef-11f67c5991d9	y	6	105	2010	n	3	n
a3280206-6f0d-4c41-8e62-7adf80c36234	8	7	2010	Tonny	Chaobi	1	2020-02-01	2020-02-06 13:35:12	f238775f-6e77-4df4-871d-7fb6fe8112b9	y	25	51	2010	y	1	n
d3f747bf-7ccf-4aa4-bde4-2cb64d9581e0	106	36	2014	Yaikhomba	Manithoiba	1	2020-02-01	2020-02-12 16:07:37	c039de78-d396-4156-94ef-11f67c5991d9	y	-1	-1	-1	n	1	n
MNHC0202-2020-f516c0	106	42	2011	Manikhomba	Muktamani	1	2020-02-01	2020-02-21 14:31:01	c039de78-d396-4156-94ef-11f67c5991d9	y	-1	-1	-1	y	1	n
MNHC0202-2020-W5W575	105	32	2013	Manikhomba	Manithoiba	1	2020-02-01	2020-02-24 13:44:18	f238775f-6e77-4df4-871d-7fb6fe8112b9	y	-1	-1	-1	y	2	n
MNHC0202-2020-U3q3UE	106	36	2014	Manikhomba	Muktamani	1	2020-02-01	2020-02-24 14:48:04	80bd49f7-a31c-4902-88f0-16cbc9740c8c	y	-1	-1	-1	y	1	y
MNHC0202-2020-21E16d	84	32	2019	Yaikhomba	Phonia	1	2020-02-01	2020-02-24 14:53:56	80bd49f7-a31c-4902-88f0-16cbc9740c8c	y	-1	-1	-1	y	2	y
MNHC0202-2020-04M557	9	42	2014	Manikanta	Muktamani	2	2020-02-01	2020-02-24 16:08:27	80bd49f7-a31c-4902-88f0-16cbc9740c8c	n	-1	-1	-1	y	1	y
MNHC0202-2020-e2G215	123	42	2019	Tonny	Chaobi	5	2020-02-01	2020-02-24 18:17:17	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	n	-1	-1	-1	y	2	y
MNHC0202-2020-39399J	102	36	2014	Manikhomba	Chaobi	2	2020-02-01	2020-02-24 20:24:07	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	n	-1	-1	-1	y	2	y
MNHC0202-2020-226897	106	42	2011	Yaikhomba	Manithoiba	1	2020-02-01	2020-02-25 13:45:27	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	y	-1	-1	-1	y	1	y
MNHC02-2020-C25478	102	42	2019	Tonny	Manithoiba	1	2020-02-01	2020-02-26 20:18:03	80bd49f7-a31c-4902-88f0-16cbc9740c8c	y	25	84	2010	y	3	y
MNHC02-2020-7283eP	106	42	2019	Sofia	Ishrar Khan	1	2020-02-01	2020-02-26 20:26:23	80bd49f7-a31c-4902-88f0-16cbc9740c8c	y	-1	-1	-1	y	1	y
MNHC02-2020-tt4361	9	36	2014	Tonny	Chaobi	1	2020-02-01	2020-02-27 11:33:04	80bd49f7-a31c-4902-88f0-16cbc9740c8c	y	-1	-1	-1	y	1	y
MNHC02-2020-6I5655	84	36	2014	Manikhomba	Chaobi	1	2020-03-01	2020-02-27 12:26:34	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	y	-1	-1	-1	y	1	y
MNHC02-2020-8W4148	106	36	2011	Manikhomba	Chaobi	1	2020-02-01	2020-02-27 14:33:31	c039de78-d396-4156-94ef-11f67c5991d9	y	-1	-1	-1	y	1	n
MNHC02-2020-b586FF	105	36	2014	Yaikhomba	Manithoiba	1	2020-02-01	2020-02-27 15:01:58	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	y	-1	-1	-1	n	1	y
MNHC03-2020-184455	3	42	2019	Yoihenba	Bonny	2	2020-03-07	2020-03-16 13:43:49	80bd49f7-a31c-4902-88f0-16cbc9740c8c	n	10	123	2013	n	1	y
MNHC03-2020-Q31542	84	43	2019	Bolivia	Sonilia	1	2020-02-05	2020-03-30 09:58:49	c039de78-d396-4156-94ef-11f67c5991d9	y	10	84	2010	y	2	n
MNHC03-2020-1j5491	132	7	2014	Manikhomba	Muktamani	1	2020-02-01	2020-03-30 10:41:55	c039de78-d396-4156-94ef-11f67c5991d9	y	-1	-1	-1	n	1	n
MNHC03-2020-815581	51	36	2014	Tonny	Chaobi	4	2020-02-15	2020-03-30 10:44:35	c039de78-d396-4156-94ef-11f67c5991d9	n	-1	-1	-1	n	4	n
MNHC04-2020-6e1056	123	42	2014	Nongpoknganba	Khomei	1	2020-04-02	2020-04-03 14:33:55	6e6cae79-b531-4596-bcbe-4cc5522c1536	y	-1	-1	-1	y	2	n
MNHC04-2020-a32875	132	23	2011	Khangembam Alex	Tomchou	1	2020-04-01	2020-04-06 14:53:15	514d2016-34ff-4a20-8277-d61af58a171a	y	-1	-1	-1	n	4	n
\.


--
-- TOC entry 3063 (class 0 OID 17138)
-- Dependencies: 203
-- Data for Name: application_tasks_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.application_tasks_log (application_tasks_log_id, application_id, user_id, action_date, action_name, tasks_id, remark, process_id, source_ip, role_id, next_tasks_id) FROM stdin;
e4f5eda9-5ac3-4ff1-807e-35731d7bbc84	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-04 20:31:47.938311+05:30	create	1	Submit a new application.	3	127.0.0.1	14	2
809ee2f3-0ff7-47af-af47-7ecb0f8a8f15	63ed9704-831a-4aea-9799-545e454e4a5f	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-06 12:13:49.448168+05:30	create	1	Submit a new application.	1	127.0.0.1	14	3
bb171950-671c-45ac-977c-3a9d01a94919	3efce6ec-2ab7-45c9-b361-ecc560cc1174	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 12:37:46.489131+05:30	create	1	Submit a new application.	1	127.0.0.1	14	3
8cd31dec-eb04-4ee4-a8f0-b3bb3b9b634c	aca15268-ceec-48f7-9921-2f32cb69e6ca	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 12:38:58.224728+05:30	create	1	Submit a new application.	3	127.0.0.1	14	2
6852f44d-bb18-4a8d-99ab-2d8afbcf3ef4	af2fbbea-4f9f-4ec3-a53b-558215f67e18	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 12:52:33.117239+05:30	create	1	Submit a new application.	1	127.0.0.1	14	3
c7e78bdf-0be3-49b8-a30f-5b4603f27e0a	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-04 12:50:58.243145+05:30	create	1	Submit a new application.	2	127.0.0.1	14	2
93fb9bee-18a2-450d-a187-b259f5e5ea59	14750714-5dc6-4e12-9240-dca5c378b3bd	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-04 20:06:22.750025+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
a0de70ff-5f89-46ab-9039-216cd4a129ff	94446f26-5a0c-4979-bbde-8a16ff936640	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 12:39:40.422377+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
80fb7b26-4ccd-49cc-8746-9639f75b92ee	1993c5a7-851c-4d76-863e-7986aa17e035	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 12:47:34.922938+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
655821c7-9c18-4b9d-9565-2984d9da5d21	f955c735-4183-4b79-8ed3-c4dbd0e07de1	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 12:55:43.167434+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
8b5e7ade-efd4-4d5a-b8db-ba3c733d898b	83e41810-e4da-41c9-b040-fac31b87057b	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-06 13:11:20.263514+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
647ca0c3-aaee-4f46-a4f1-01b71831278a	68a4fbfd-a174-4171-a059-7f9624259753	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-06 13:12:10.628875+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
92ee813f-0a59-4808-be6d-5109661a98d8	a3280206-6f0d-4c41-8e62-7adf80c36234	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-06 13:35:12.515937+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
4bcc7528-08ae-40ac-8f4c-f50646f3f24c	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	e4b7fc43-406d-437b-a946-a22d7bc52d38	2020-02-07 16:22:32.700079+05:30	forward	2	1	3	127.0.0.1	9	3
54c54669-0fff-468a-82d4-554dfe699b9e	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	e4b7fc43-406d-437b-a946-a22d7bc52d38	2020-02-07 16:27:17.075765+05:30	forward	2	1	3	127.0.0.1	9	3
02a78d55-3eea-4511-9fde-4481aba0db76	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-07 17:55:00.740021+05:30	forward	3	1	3	127.0.0.1	2	4
51e0989c-d554-4536-b3ee-c2ae5bdc3228	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25	2020-02-07 18:17:57.011061+05:30	forward	4	1	3	127.0.0.1	11	5
6647139e-0511-4b57-94e0-ea1e3d4a1e2c	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-02-07 20:30:16.197443+05:30	forward	5	Certificate upload.	3	127.0.0.1	12	6
32947732-f604-4cab-9310-bf73d017e643	af2fbbea-4f9f-4ec3-a53b-558215f67e18	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-10 13:07:47.809743+05:30	forward	3		1	127.0.0.1	2	4
50f64c7a-fe13-48b8-8393-5371d88b695b	a3280206-6f0d-4c41-8e62-7adf80c36234	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-10 13:09:23.698557+05:30	forward	3		2	127.0.0.1	2	5
6e30682f-04cf-40e9-b245-e3b98c4ad2e9	af2fbbea-4f9f-4ec3-a53b-558215f67e18	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25	2020-02-10 13:11:17.777992+05:30	forward	4		1	127.0.0.1	11	5
a5b34404-2ffe-4ff4-be70-0782f05439ec	af2fbbea-4f9f-4ec3-a53b-558215f67e18	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-02-10 13:12:10.053146+05:30	forward	5	Certificate upload.	1	127.0.0.1	12	6
195a56ca-91c2-499e-836e-85ab9f846ad2	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-11 15:57:34.633641+05:30	approve	6		3	127.0.0.1	2	\N
8ce5ae5e-1729-4b35-b1b6-470d566b56fc	af2fbbea-4f9f-4ec3-a53b-558215f67e18	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-11 16:00:29.446594+05:30	approve	6		1	127.0.0.1	2	\N
f7ccf6ba-a2f3-4e80-8bea-e179249efb5a	d3f747bf-7ccf-4aa4-bde4-2cb64d9581e0	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-12 16:07:37.31793+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
19e8b385-855d-47bc-981f-76e276ad8293	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-12 21:06:02.861856+05:30	forward	3		3	127.0.0.1	2	4
d924dda3-1c14-45eb-8264-4509df717072	MNHC0202-2020-f516c0	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-21 14:31:01.745245+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
79c18f59-6aaf-486e-940b-13a5766ddada	MNHC0202-2020-W5W575	f238775f-6e77-4df4-871d-7fb6fe8112b9	2020-02-24 13:44:18.085387+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
bdd42c31-da67-4e2e-9565-1bb8925f0a40	MNHC0202-2020-U3q3UE	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-24 14:48:04.557455+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
8018f67c-556b-44c2-bad8-e3a6bc422d9a	MNHC0202-2020-21E16d	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-24 14:53:56.880026+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
915ef717-26cb-4bcf-b933-f18e962432e4	MNHC0202-2020-04M557	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-24 16:08:27.006663+05:30	create	1	Submit a new application.	3	127.0.0.1	2	2
a59dd9b8-281f-4376-9580-bbe612e83378	MNHC0202-2020-e2G215	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-24 18:17:17.153122+05:30	create	1	Submit a new application.	3	127.0.0.1	2	2
4f5ace51-fa2d-4bb5-902f-50529db14b4e	MNHC0202-2020-39399J	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-24 20:24:07.520303+05:30	create	1	Submit a new application.	3	127.0.0.1	2	2
117123f1-d7e2-4eb3-83c5-3b4480e6ea67	MNHC0202-2020-226897	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-25 13:45:27.962609+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
cb645b68-a52d-499f-829b-339baa104718	MNHC02-2020-C25478	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-26 20:18:03.255326+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
01febe0c-25be-4cf8-8860-eb3d8c0748c1	MNHC02-2020-7283eP	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-26 20:26:23.936558+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
249fedfc-3deb-46df-bf57-470081d922e8	MNHC02-2020-tt4361	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-27 11:33:04.198625+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
9f01c210-d860-46d9-9632-f0c3d3e31af9	MNHC02-2020-6I5655	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-27 12:26:34.60975+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
1ecefba7-ad9e-490c-bd3c-e04f2b085a51	MNHC02-2020-tt4361	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-27 13:08:20.406574+05:30	forward	3		2	127.0.0.1	2	5
1700304f-7bc7-49f2-9a88-564ee29dfd7b	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25	2020-02-27 13:33:48.974948+05:30	forward	4		3	127.0.0.1	11	5
36137593-5683-44dc-b1e1-cb40f5073507	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-02-27 13:34:40.391075+05:30	forward	5	Certificate upload.	3	127.0.0.1	12	6
06ff93b5-aafb-4871-a280-bf4aa9974f89	MNHC02-2020-tt4361	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-02-27 13:36:30.555738+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
2cce5f76-f0db-42d0-b17e-ffa2b2506106	a3280206-6f0d-4c41-8e62-7adf80c36234	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-02-27 13:37:51.278916+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
3e13e076-8f97-41dd-a597-602426543f1b	MNHC02-2020-tt4361	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-02-27 13:40:11.347182+05:30	approve	6		2	127.0.0.1	2	\N
5806b1f7-a9ec-4b04-abfe-66f5c384dc9b	MNHC02-2020-8W4148	c039de78-d396-4156-94ef-11f67c5991d9	2020-02-27 14:33:31.835031+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
4b97dc6c-0f8f-4af8-8520-df102536ddb3	MNHC02-2020-8W4148	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-27 14:40:25.842157+05:30	forward	3		2	127.0.0.1	2	5
467c81f4-c0b5-4860-96d2-32ac9b7d1e12	MNHC02-2020-8W4148	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-02-27 14:42:22.531803+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
fc97a9d8-a7d1-48db-a51f-532b4b353f38	MNHC02-2020-b586FF	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-27 15:01:58.594209+05:30	create	1	Submit a new application.	2	127.0.0.1	2	3
bcdbe7ff-ec43-4b0c-a7a3-118d2dd3279e	MNHC02-2020-b586FF	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-27 15:22:54.923789+05:30	reject	3	test reject	2	127.0.0.1	2	5
5bd1efe8-5780-4b7d-adac-cfa2b8611301	MNHC02-2020-6I5655	f9f63fae-b09d-41bf-a915-9aa75fd40f0f	2020-02-27 15:26:46.20095+05:30	forward	3		2	127.0.0.1	2	5
2efa3cd0-30bf-4c60-81cd-e3c04320b494	MNHC03-2020-184455	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-03-16 13:43:49.931402+05:30	create	1	Submit a new application.	1	10.178.2.133	2	3
5f3652a5-8ade-4815-ad7f-517f8e435bc6	83e41810-e4da-41c9-b040-fac31b87057b	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-03-19 15:50:53.041921+05:30	forward	3		2	10.178.2.133	2	5
a02c7c2c-4dd3-4bfd-bfa2-a9dbf1d6c860	f955c735-4183-4b79-8ed3-c4dbd0e07de1	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-03-19 15:51:54.865876+05:30	forward	3		2	10.178.2.133	2	5
c5ee24fc-3e63-48a8-95c4-994000e36296	MNHC02-2020-8W4148	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-03-19 16:46:12.03267+05:30	approve	6		2	10.178.2.133	2	\N
5a4dc554-9f66-4bd1-8ff5-c46a3346b28a	MNHC03-2020-Q31542	c039de78-d396-4156-94ef-11f67c5991d9	2020-03-30 09:58:49.146789+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
a9560681-9ca4-4a3d-bce5-83939547e698	MNHC03-2020-1j5491	c039de78-d396-4156-94ef-11f67c5991d9	2020-03-30 10:41:55.692998+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
14b5b71a-0bb0-48bd-b90d-682d6a7ac958	MNHC03-2020-815581	c039de78-d396-4156-94ef-11f67c5991d9	2020-03-30 10:44:35.044366+05:30	create	1	Submit a new application.	1	127.0.0.1	14	3
d1a00174-9f95-4fe0-a460-ba25059b852f	14750714-5dc6-4e12-9240-dca5c378b3bd	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-04-01 15:37:44.386392+05:30	forward	3		2	127.0.0.1	2	5
54967eab-7ab4-4d2e-a0af-1d2ecffa6007	68a4fbfd-a174-4171-a059-7f9624259753	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-04-01 15:38:06.712361+05:30	forward	3		2	127.0.0.1	2	5
5d90d4a2-e416-429e-9963-73c1c884fc54	MNHC02-2020-7283eP	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-04-01 15:40:58.085482+05:30	forward	3		2	127.0.0.1	2	5
d8b80760-f0d9-4314-848e-aa5475e334d6	MNHC02-2020-C25478	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-04-01 15:41:16.63976+05:30	forward	3		2	127.0.0.1	2	5
9743cecd-542c-473d-a001-03b28ecebc21	MNHC02-2020-C25478	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-04-01 15:44:37.087273+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
d0e2c0d0-f763-45a6-97ce-e526afbbb88e	MNHC02-2020-6I5655	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-04-01 15:50:24.364405+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
f78e47d2-de87-4a6e-88c6-2f364845ea07	83e41810-e4da-41c9-b040-fac31b87057b	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-04-01 15:51:16.426868+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
37d17873-aff8-4c21-aa6c-26bfe5965b52	MNHC02-2020-7283eP	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-04-01 15:52:04.303942+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
77aace7b-73bf-4d87-8406-ca41085e3e4d	68a4fbfd-a174-4171-a059-7f9624259753	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	2020-04-01 16:09:20.400304+05:30	forward	5	Certificate upload.	2	127.0.0.1	12	6
9447c029-f933-4187-a838-73e9e1590f27	MNHC04-2020-6e1056	6e6cae79-b531-4596-bcbe-4cc5522c1536	2020-04-03 14:33:55.264881+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
82a95fb7-e22f-4cd1-bc65-b9b6664e882d	MNHC04-2020-a32875	514d2016-34ff-4a20-8277-d61af58a171a	2020-04-06 14:53:15.012214+05:30	create	1	Submit a new application.	2	127.0.0.1	14	3
e26d9ece-9a6d-470f-b518-34beb5d504b6	MNHC02-2020-7283eP	80bd49f7-a31c-4902-88f0-16cbc9740c8c	2020-07-16 14:25:44.373683+05:30	approve	6		2	127.0.0.1	2	\N
\.


--
-- TOC entry 3064 (class 0 OID 17147)
-- Dependencies: 204
-- Data for Name: case_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.case_type (case_type_id, type_name, ltype_name, full_form, lfull_form, type_flag, filing_no, filing_year, reg_no, reg_year, display, petitioner, respondent, lpetitioner, lrespondent, res_disp, case_priority, national_code, macp, stage_id, matter_type, cavreg_no, cavreg_year, direct_reg, cavfil_no, cavfil_year, ia_filing_no, ia_filing_year, ia_reg_no, ia_reg_year, tag_courts, amd, create_modify, est_code_src, reasonable_dispose) FROM stdin;
131	Spl. T POCSO		Special Trial POCSO		2	0	0	3	2019	Y	Prosecution	Accused			0	0	6001	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-05-13 15:17:43.238017	MNIE01	\N
134	Spl. T.NIA.Case		Special Trial NIA Case		2	0	0	1	2019	Y					0	0	6001	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 13:14:08.463315	MNIE01	\N
138	Spl. T. (SC  ST, POA) Case		Special Trial (SC and ST, POA) Case		2	0	0	1	2019	Y					0	0	6001	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 13:31:36.836493	MNIE01	\N
124	Cril (C)		Criminal Complaint		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6002	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:50:03.608334	MNIE01	\N
88	S.T.		Sessions Trial		2	0	0	2	2019	Y	Prosecution	Accused			0	0	6001	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:51:50.536295	MNIE01	\N
127	F.i.r	\N	F.I.R	\N	2	0	2016	0	2019	N	Prosecution	Accused	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
38	Judl. Misc.		Misc. ( J) Case		1	0	0	35	2019	Y	Plaintiff Name	Defendent Name			0	0	5014	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-17 14:03:52.921366	MNIE01	\N
137	Cril. Misc. FR		Criminal Misc. Final Report		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6008	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
69	Sessions ( Spl.)	\N	Sessions ( Spl.)	\N	2	0	2016	0	2019	N	Prosecution	Accused	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
105	C Ex.		Civil Execution		1	0	0	1	2019	Y	Plaintiff Name	Defendent Name			0	0	5006	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-02-14 11:59:08.390747	MNIE01	\N
110	Cril Misc.(Con.)		Criminal Misc. (Condonation)		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:50:36.840232	MNIE01	\N
10	Cril. Revn		Criminal Revision		2	0	0	0	2019	Y	Revisionist	Respondent			0	0	6004	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:50:50.114493	MNIE01	\N
94	O.S. (Succ)		Original Suit(succession)		1	0	0	2	2019	Y	Plaintiff Name	Defendent Name			0	0	5001	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:52:12.542548	MNIE01	\N
103	O.S. (Prob)		Original (Probate) Suit		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5014	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:52:36.661906	MNIE01	\N
102	C.A.		Civil Appeal		1	0	0	7	2019	Y	Plaintiff Name	Defendent Name			0	0	5012	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-17 15:36:57.73223	MNIE01	\N
120	Exec.		Execution Case		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5006	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
99	O.S. (MH/GW)		Original Suit(MH/GW)		1	0	0	1	2019	Y	Plaintiff Name	Defendent Name			0	0	5014	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:53:11.568323	MNIE01	\N
121	O.S. (G/W)		Original(G / W) Suit .		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5014	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:53:36.50327	MNIE01	\N
130	Cril.misc.(z)	\N	Cril.Misc.(Z)	\N	2	0	2016	0	2019	N	Prosecution	Accused	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
122	N.I.A.		National Investigation Agency		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6001	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:54:31.998064	MNIE01	\N
92	Judl. Misc (Enq)		Judicial Misc. (Enquiry)		1	0	0	1	2019	Y	Plaintiff Name	Defendent Name			0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:56:00.62163	MNIE01	\N
95	M.C.A.		Misc. Civil Appeal		1	0	0	3	2019	Y	Plaintiff Name	Defendent Name			0	0	5018	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-04-30 12:21:20.112173	MNIE01	\N
126	FIR		First Investigation report		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6008	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
129	O.s.(hmga)	\N	Original Suit(HMGA)	\N	1	0	2016	0	2019	N	Plaintiff Name	Defendent Name	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
3	Cril. Misc. (AB)		Cril misc (Anticipatory Bail)		2	0	0	40	2019	Y	Petitioner	Respondent			0	0	6005	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:48:59.061497	MNIE01	\N
116	Cril. Misc. (T)		Criminal Misc. (Transfer)		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:49:13.458589	MNIE01	\N
108	Sess trl		Session Trial		1	0	0	0	2019	N	Plaintiff Name	Defendent Name			0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
111	Cril. Misc.(Z)		Criminal Misc. (Zima)		2	0	0	7	2019	Y	Petitioner	Respondent			0	0	6007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:50:21.73245	MNIE01	\N
125	Civil Revn		CIVIL REVISION		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5013	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
133	Cross Obj		Cross Objection		1	0	0	0	2019	Y	Plaintiffs				0	0	5012	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
93	Os(m/h&g/w)	\N	Original Suit(M/H&G/W)	\N	1	0	2016	0	2019	N	Plaintiff Name	Defendent Name	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
68	Cril. Misc. (B)		Criminal Misc. (B)		2	0	0	39	2019	Y	Accused/Petitioner	Respondent			0	0	6007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-17 14:49:29.09378	MNIE01	\N
104	O.S. (Guardian)		Original(Guardianship) Suit		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5014	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:53:52.646496	MNIE01	\N
6	Complt. Case		Complaint Case		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6002	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
114	O.S. (Adoption)		Original(Adoption)Suit		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5014	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:54:00.801015	MNIE01	\N
113	D.t.		Designated Trial Case		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6001	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
128	O.s.(hmga)	\N	Original Suit(HMGA)No.	\N	1	0	2016	0	2019	N	Plaintiff Name	Defendent Name	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
107	Judl. Misc(C)		Judicial Misc.(Condonation)		1	0	0	1	2019	Y	Plaintiff Name	Defendent Name			0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:54:45.184615	MNIE01	\N
136	Spl. T. Elect.		Special Trial Electricity		2	0	0	0	2019	Y					0	0	6001	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
101	Judl. Misc. (Transfer)		Judicial Misc.(Transfer)		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:55:03.024617	MNIE01	\N
60	Special Case ( Corruption Case )		Special Case ( Corruption Case		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6001	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
132	Civil Review		Civil Review		1	0	0	0	2019	Y					0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
115	O.s.(probate)		Original(Probate)Suit		1	0	2016	0	2019	N	Plaintiff Name	Defendent Name			0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
15	Excise Act	\N	Excise Act	\N	2	0	2016	0	2019	N	Prosecution	Accused	\N	\N	0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
135	Mediation		Mediation		1	0	0	0	2019	Y	First Party	Second Party			0	0	5016	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
51	Comp Case		Complaints Cases		2	0	0	0	2019	N	Prosecution	Accused			0	0	0	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-01-02 10:38:19.383934	MNIE01	\N
106	ARB.		Arbitration		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:47:27.878048	MNIE01	\N
8	Cril. Appl		Criminal Appeal		2	0	0	3	2019	Y	Appellant	Respondent			0	0	6003	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:48:10.166623	MNIE01	\N
97	Judl. Misc. (Stay)		JudicialMisc.(Stay)		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:55:26.209875	MNIE01	\N
96	Judl. Misc (Restor)		Judicial Misc. (Restoration)		1	0	0	4	2019	Y	Plaintiff Name	Defendent Name			0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:55:40.718253	MNIE01	\N
109	Cril. Misc.(T)		Criil.Misc.(Transfer)		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:49:19.691404	MNIE01	\N
123	Cril (P)		Criminal police case		2	0	0	0	2019	Y	Prosecution	Accused			0	0	6002	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:49:26.833532	MNIE01	\N
117	Judl. Misc (Amend)		Judl. Misc. (Amend)		1	0	0	1	2019	Y	Plaintiff Name	Defendent Name			0	0	5016	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:56:13.632208	MNIE01	\N
84	Cril. Misc Appeal		Misc appeal (Crl)		2	0	0	2	2019	Y	Appellant	Respondent			0	0	6003	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:49:47.252627	MNIE01	\N
91	Spl. T		Special Trial		2	0	0	2	2019	Y	Prosecution	Accused			0	0	6001	N	\N	0	0	0	N	0	0	0	0	0	0	\N	U	2019-04-11 12:17:31.132658	MNIE01	\N
9	Cril. Misc.		Criminal Miscellaneous		2	0	0	77	2019	Y	Petitioner	Respondent			0	0	6007	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-17 13:12:30.049517	MNIE01	\N
100	O.S (LA)		Original Suit(LA)		1	0	0	0	2019	Y	Plaintiff Name	Defendent Name			0	0	5004	N	\N	3	0	0	N	0	0	0	0	0	0	\N	U	2019-05-15 15:53:24.874614	MNIE01	\N
\.


--
-- TOC entry 3067 (class 0 OID 17201)
-- Dependencies: 208
-- Data for Name: casebody; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.casebody (casebody_id, case_type_id, case_number, case_year, document_path, created_at, created_by) FROM stdin;
1	148	78	2016	../Uploads/documents/case_body/SummDe.pdf	2020-01-12 11:30:16+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
2	153	23	2014	../Uploads/documents/case_body/Manda.pdf	2020-01-12 21:47:29+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
3	153	3	2011	../Uploads/documents/case_body/LIC CASH VOUCHER.pdf	2020-01-13 12:44:04+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
4	148	6	2011	../Uploads/documents/case_body/6_2011_148/MPR_JAN_2018.pdf	2020-01-13 13:34:21+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
5	150	3	2010	../Uploads/documents/case_body/3_2010_150/BCM new Notice.pdf	2020-01-14 21:34:00+05:30	1d6ce7ba-7161-487f-b566-7202e9222174
6	153	87	2013	../Uploads/documents/case_body/87_2013_153/BCM new Notice.pdf	2020-01-15 17:00:23+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
7	153	4	2011	../Uploads/documents/case_body/4_2011_153/LIC CASH VOUCHER.pdf	2020-01-15 17:09:46+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
8	153	87	2011	../Uploads/documents/case_body/87_2011_153/housie_report9nov.pdf	2020-01-15 19:28:55+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
9	86	8	2011	../Uploads/documents/case_body/8_2011_86/Phamthoibi.pdf	2020-01-16 08:43:37+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
10	150	21	2010	../Uploads/documents/case_body/21_2010_150/salary_proof.pdf	2020-01-16 08:44:10+05:30	030c2683-8ff2-47f8-81fa-f05dd8657f58
11	133	36	2011	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2011_133/Housie Collection Record.pdf	2020-02-07 17:51:25+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
12	106	7	2011	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/7_2011_106/Manda.pdf	2020-02-07 17:54:52+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
13	8	42	2016	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/42_2016_8/mpr_jan2018.pdf	2020-02-10 13:07:40+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
14	8	7	2010	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/7_2010_8/BCM new Notice.pdf	2020-02-10 13:08:42+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
15	9	36	2014	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2014_9/test.pdf	2020-02-27 13:08:14+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
16	106	36	2011	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2011_106/certified.pdf	2020-02-27 14:40:18+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
17	105	36	2014	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2014_105/casebody.pdf	2020-02-27 15:19:47+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
18	84	36	2014	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2014_84/casebody.pdf	2020-02-27 15:23:48+05:30	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
19	106	42	2019	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/42_2019_106/SalaryPending.pdf	2020-03-04 12:17:52+05:30	80bd49f7-a31c-4902-88f0-16cbc9740c8c
20	106	42	2014	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/42_2014_106/SalaryPending.pdf	2020-03-19 15:45:35+05:30	80bd49f7-a31c-4902-88f0-16cbc9740c8c
21	8	36	2019	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2019_8/invitations.pdf	2020-03-19 15:51:35+05:30	80bd49f7-a31c-4902-88f0-16cbc9740c8c
22	51	6	2010	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/6_2010_51/test.pdf	2020-04-01 15:37:36+05:30	80bd49f7-a31c-4902-88f0-16cbc9740c8c
23	8	36	2014	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/36_2014_8/test.pdf	2020-04-01 15:38:02+05:30	80bd49f7-a31c-4902-88f0-16cbc9740c8c
24	102	42	2019	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/case_body/42_2019_102/test.pdf	2020-04-01 15:41:09+05:30	80bd49f7-a31c-4902-88f0-16cbc9740c8c
\.


--
-- TOC entry 3061 (class 0 OID 17133)
-- Dependencies: 201
-- Data for Name: certificate_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.certificate_type (certificate_type_id, name) FROM stdin;
1	Certify
2	Uncertify
4	Uncertify (Urgent)
3	Certify (Urgent)
\.


--
-- TOC entry 3065 (class 0 OID 17184)
-- Dependencies: 205
-- Data for Name: copy_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.copy_type (copy_type_id, copy_name) FROM stdin;
1	Order Copy
2	Petition Copy
3	Counter Affidavit or Affidavit
4	Reply Affidavit
5	Vakalatnama
6	Others
\.


--
-- TOC entry 3056 (class 0 OID 17118)
-- Dependencies: 196
-- Data for Name: document; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.document (document_id, application_id, document_path, create_at, delete_at, created_by, update_at) FROM stdin;
1	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/1fcb7ec7-90d0-4c0f-a775-62a07ff0656b/BCM new Notice.pdf	2020-02-07 20:30:16+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
2	af2fbbea-4f9f-4ec3-a53b-558215f67e18	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/af2fbbea-4f9f-4ec3-a53b-558215f67e18/Manda.pdf	2020-02-10 13:12:10+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
3	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/acd8118b-d4af-4bd4-bacb-f9d708c0afdc/LIC CASH VOUCHER.pdf	2020-02-27 13:34:40+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
4	MNHC02-2020-tt4361	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/MNHC02-2020-tt4361/PrmPayRcpt-16759667.pdf	2020-02-27 13:36:30+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
5	a3280206-6f0d-4c41-8e62-7adf80c36234	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/a3280206-6f0d-4c41-8e62-7adf80c36234/PrmPayRcpt-16755813.pdf	2020-02-27 13:37:51+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
6	MNHC02-2020-8W4148	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/MNHC02-2020-8W4148/casebody.pdf	2020-02-27 14:42:22+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
7	MNHC02-2020-C25478	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/MNHC02-2020-C25478/casebody.pdf	2020-04-01 15:44:37+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
8	MNHC02-2020-6I5655	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/MNHC02-2020-6I5655/certified.pdf	2020-04-01 15:50:24+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
9	83e41810-e4da-41c9-b040-fac31b87057b	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/83e41810-e4da-41c9-b040-fac31b87057b/SummDe4.pdf	2020-04-01 15:51:16+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
10	MNHC02-2020-7283eP	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/MNHC02-2020-7283eP/invoice.pdf	2020-04-01 15:52:04+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
11	68a4fbfd-a174-4171-a059-7f9624259753	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/certificate/68a4fbfd-a174-4171-a059-7f9624259753/test.pdf	2020-04-01 16:09:20+05:30	\N	6c6ca4dd-0ef6-4584-8d01-ea922578fa20	\N
\.


--
-- TOC entry 3069 (class 0 OID 17211)
-- Dependencies: 211
-- Data for Name: logins; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.logins (login_id, login_time, logout_time, expiry, source_ip, device, user_id) FROM stdin;
09ia49zodge1D3JogL5A6CXdNW983B33atZaB9WN2D1m54giaZEae93D196J	2019-12-13 19:51:23+05:30	\N	2019-12-13 20:21:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
2R6m3qgWjVyme4Ub48F89beOgfWbqPPc2sm98Jwq8R6Xddf7fRzIufm4N16X	2019-12-13 20:31:24+05:30	\N	2019-12-13 21:01:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
w24SR6C7KMT9f8KYUdE7Y91VC6nYulE2Y1C2m6afUu0Cm01zK3IB8nYIM5KJ	2019-12-11 13:26:12+05:30	\N	2019-12-11 13:36:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
b45Ug61xX7XYM0dqEhA60q5Y61g00b3gqx7G3vGFg2UGf11bzvA65hw6NU5f	2019-12-10 14:49:28+05:30	\N	2019-12-10 15:27:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9qZ7n0f1fE8S35kqsJ85588Zq2Zd74oax47ot7ds5ah999x992JJ54k5fxDD	2019-12-11 13:28:19+05:30	2019-12-11 13:30:08+05:30	2019-12-11 13:58:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
CK99iQYZpVNG6NE56880y68NfwZk72LkKHE5EINdyiHdFNC5fp2wM8k9878Z	2019-12-11 13:30:24+05:30	2019-12-11 13:52:25+05:30	2019-12-11 14:00:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
jf6d6Gyos75Gff27NO5EPA2gdPAo0181OuEZ597g1dR6RNe6bN0Njjo356P5	2019-12-12 11:22:36+05:30	\N	2019-12-12 11:52:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	514d2016-34ff-4a20-8277-d61af58a171a
w3d20JYG7sWapg7GB5xp5uI305nW63yh8BLcGc76pGuPp39p883ppfv9n30u	2019-12-10 20:32:22+05:30	\N	2019-12-10 20:44:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
ZxC1Vajxlf2IEQf6wq3l371aG0Bfh741E8Q6Vf3QI0f3216fQh1ilZI1ZI2x	2019-12-11 13:17:38+05:30	2019-12-11 13:25:15+05:30	2019-12-11 13:35:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
hpXhd55LM22Nc6011212NMprh8QU8qh687q7fRbN4pbd07pQ1w6UC7sbR7C5	2019-12-11 13:11:05+05:30	2019-12-11 13:14:33+05:30	2019-12-11 13:24:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
MdBxMZ76Vt5kgjb85ggQjxOQjMj6fgM6BE1p5dPP76U660uBe765TVj9Zkqi	2019-12-10 16:22:36+05:30	\N	2019-12-10 16:35:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
45Ta5ph9PethKv9950J9f4G5WG9E2tIiP595hvUJga10aKYx65t59TP7I539	2019-12-10 19:34:09+05:30	\N	2019-12-10 19:45:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7f4d1H4292dz12bUHWE17f23h1R176ud506TJq7Ex7ott5b5IzwdzI9Jt27J	2019-12-10 15:33:37+05:30	\N	2019-12-10 16:08:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9h991P9JRh93e9fh6563g11aPfKF2rr795362maD9c139hn006raJ326IFX0	2019-12-10 17:37:12+05:30	2019-12-10 17:40:36+05:30	2019-12-10 17:50:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
728nC4WEt6W121Xne9nqwst2e9e85T8c88STmc2qTeLmefzedcf7j7d278Kw	2019-12-10 17:04:42+05:30	2019-12-10 17:28:52+05:30	2019-12-10 17:38:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9MF41WR1iMl5eM130dZbl247dw0aZW1qld1594153i7p9Q9G9q3pCN5G756G	2019-12-12 12:48:58+05:30	\N	2019-12-12 13:18:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	514d2016-34ff-4a20-8277-d61af58a171a
bs1L3YYqR1932NDW2LLJwq6M1991Rp661P8M5eLvp5tYLq76YlLyYWb5SBSs	2019-12-12 13:21:02+05:30	2019-12-12 13:34:34+05:30	2019-12-12 13:51:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	514d2016-34ff-4a20-8277-d61af58a171a
lTZlf59kvvf7cP57T9D7C5RPF5bt64p7il51j39dFZ1xJ05Mfi7vcma98ilp	2019-12-10 14:21:52+05:30	2019-12-10 14:47:45+05:30	2019-12-10 14:57:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
aFEfFd7m7MF971E5fz2GY3U1dBf87elyzFvahvEgvEa71vz7EGU73IvpMeDl	2019-12-12 23:01:02+05:30	\N	2019-12-12 23:31:02+05:30	::1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
n17gGh7mPgc52e87nn1TK5571m6h080esE30l6c66mE1424E1u4G88z7n086	2019-12-11 13:14:47+05:30	2019-12-11 13:15:15+05:30	2019-12-11 13:25:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
1t58AfbC561d49m3LYg7Qb61NckXzRXY77Rtx5addR8547Zac59YN6eNFvde	2019-12-10 21:57:48+05:30	\N	2019-12-10 22:07:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
F2IRa5FoK3EdE1W56eo1b876Oa7WZg7r62EaF15t2LknMgT70k0taRIjd31N	2019-12-11 13:25:33+05:30	2019-12-11 13:25:58+05:30	2019-12-11 13:35:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
j290B5123161e5jL5240MNBsV97N36Ib0541jeeA9kXQD41nrh339geeVpy8	2019-12-12 23:01:44+05:30	2019-12-12 23:02:05+05:30	2019-12-12 23:31:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
597lVl753pV87mxD32fljQSe37m5DpxYywGG568zVm5D12BdSd8dyB79BtcZ	2019-12-13 18:36:36+05:30	2019-12-13 18:37:18+05:30	2019-12-13 19:06:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	f238775f-6e77-4df4-871d-7fb6fe8112b9
1699v7Cq1tvIs0e9WvsmYd22Ua28YIbufHpCoxx7HW192dM6pO696qFIbH2e	2019-12-14 19:40:27+05:30	2019-12-14 19:41:42+05:30	2019-12-14 20:10:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
9I4pMy6sadEn5c99EaO2t1j9bSagHey1a2WY58ntObV2EdVd9exdOSd5Dd6M	2019-12-14 19:41:58+05:30	2019-12-14 20:03:06+05:30	2019-12-14 20:11:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
85kbOMwucn277b32Oma4pVnSe56642m2Mt7Ud29gthpY79geOBXF3mbuu225	2019-12-14 20:06:43+05:30	2019-12-14 20:18:43+05:30	2019-12-14 20:36:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
y64Rf4WfknY3nx3aQ9BeCn41xFTwkxpq10e5mFmn65c7abk65aAJQ0n6w5TY	2019-12-14 20:19:00+05:30	2019-12-14 20:21:53+05:30	2019-12-14 20:49:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
w7iPEeQ1Ya176iFF52fuz75e59Add45pffAZA404x1hF6GMdvvu95fw23j0m	2019-12-15 16:24:39+05:30	\N	2019-12-15 16:54:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
VO0qw6V6Vq45QO05v4brBO166iwFm4BC0a7lFX3j6f4OV8DS5meSO0sDLgC4	2019-12-15 16:49:17+05:30	\N	2019-12-15 17:19:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
585f45yha15cF74MXdAO2C0sb14MQ61c6cWJ0pD618hXYD0LMWfF36Q55M17	2019-12-15 17:24:36+05:30	\N	2019-12-15 17:54:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
4foefVW413xB336GHPeW6G06x56Vx5Lx91WHx6JFJH09UsAUssfO7f0d9Wsa	2019-12-15 18:07:45+05:30	\N	2019-12-15 18:37:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
4meaR60djj8W1801UaP09KdKf1HPB817bdsbWUaE8jB68y1x78fcaR9jhA5H	2019-12-15 20:10:10+05:30	2019-12-15 20:14:55+05:30	2019-12-15 20:40:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9m3s263i79512qXk345xop7muV46x1u2Bfnudv2p261d43UH3nUnz7vds7v8	2019-12-15 20:41:52+05:30	\N	2019-12-15 21:11:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
Md5lvMN9Pq7Ly2LPjJH7P0d526z965d5km56hbja56989Ld89mz2yEid4XB6	2019-12-15 21:19:46+05:30	\N	2019-12-15 21:49:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
a2b07720c9OfGiHDc62OZQv9O028OcD48mW0181q8xrd0fbra5OuByvu3a69	2019-12-15 21:51:07+05:30	\N	2019-12-15 22:21:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
c05e7FT5lTTLlG7I6l5KqVHl7d2l9xHv5dOhBOFK7EqIn6ES71O54siqeES1	2019-12-15 22:01:11+05:30	2019-12-15 23:00:50+05:30	2019-12-16 01:01:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
S05z1P43S4406nrVp94y68Vbnn1GSwwJSy3D007bVn45HJngaRy877f05n58	2019-12-16 13:22:08+05:30	2019-12-16 13:27:22+05:30	2019-12-16 16:22:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7b90798546mkq51azri3a615z67bRmUmqL764acqmml7ke7eZ2LfHZq6eQq1	2019-12-16 20:43:56+05:30	2019-12-16 20:49:10+05:30	2019-12-16 23:43:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
55280G22mda716d14269aX85ESDSm17a61adod9d1276j6I7I7Nedw5IkHdn	2019-12-16 21:14:50+05:30	2019-12-16 21:51:10+05:30	2019-12-17 00:14:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
ee3M65b7mpbY7adA01fejb0bcQ20ae7VMcrwuk2720a4f40r5103h05445br	2019-12-16 21:56:10+05:30	2019-12-16 22:03:53+05:30	2019-12-17 00:56:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
6QvcQldf55G6w8Foh2obWoMeC2lLGFg9szmT45uv5T49XY4arqb8F2wZsBWa	2019-12-17 14:35:50+05:30	2019-12-17 14:59:09+05:30	2019-12-17 17:35:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
198d7Dj1L651Wkwz1VcAt1scW51eY88Ldz8cd13cmj7dF6w681vei61LCca1	2019-12-17 17:48:20+05:30	2019-12-17 18:48:03+05:30	2019-12-17 20:48:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
4OO71lU5l9OHxU7eL9jxG6ckkt6H05255Z5x4q452H9U0787VV622S75eTT3	2019-12-18 18:18:10+05:30	2019-12-18 19:01:35+05:30	2019-12-18 21:18:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
6GG7mQXx5Y9kwU629VmU18a6EWGOk0JQZZBx5GuUNpqdSH5Q5YHS2976aZaS	2019-12-18 19:16:36+05:30	2019-12-18 19:29:51+05:30	2019-12-18 22:16:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
P7mG0nu248vfe010pbBp376077p1LZE44Z13H707UaeGLFeHd86Z264pFLs0	2019-12-18 19:30:28+05:30	2019-12-18 19:35:16+05:30	2019-12-18 22:30:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
7k0tPf5714CjB22a635KVPa332S2322l5Y3d473VH3Y1BkB5a3S1V72Z2kKD	2019-12-18 19:35:43+05:30	2019-12-18 19:39:31+05:30	2019-12-18 22:35:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
W3rRecRQ5Y95Co688rkeuY6G3478u6534sorWcdu4c93cJ8u6eo6wdCHJ6uU	2019-12-18 20:24:20+05:30	2019-12-18 20:28:59+05:30	2019-12-18 23:24:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
kC5fvr1EdmfVIf5reIZZ65meeOl1pIRR8EEZ0IM05ON7Ll1580k6v1rd1Sfk	2019-12-18 20:29:58+05:30	2019-12-18 20:51:09+05:30	2019-12-18 23:29:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
IZ1B1ew5sq8180Ce64Ik5evvdvf16fp1f62dk3qdfn2n21xv1727Y7e7032z	2019-12-18 20:51:21+05:30	2019-12-18 21:10:35+05:30	2019-12-18 23:51:21+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
Alz58NxUD8PL0fh4fWf38T7m7TODA0y81la34nG5Abf72Cx0GW156ff4qT6x	2019-12-18 21:10:56+05:30	2019-12-18 23:57:30+05:30	2019-12-19 00:10:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
fELfn9661ap0lL44Hn1lU9cfdO61H75sNS117e9d45IB0eqbe51W441E5dSU	2019-12-19 07:02:49+05:30	2019-12-19 07:22:53+05:30	2019-12-19 10:02:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
050xF74UmoLa5AoJ148K045f80Ich8j8xwiddH2i1y8AOo183o0w81o45W0f	2019-12-19 07:23:08+05:30	2019-12-19 07:26:13+05:30	2019-12-19 10:23:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
en3eyVc5Oljb985y1V5peWbebkclIl68jS9Om5WeLcS8rwvOSj5Dgk9bgDdc	2019-12-19 07:26:37+05:30	2019-12-19 07:34:21+05:30	2019-12-19 10:26:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
1ihkC4xdGA335Wl7vP1637P90675GNGxlxI3lzhNP6tG1xZw5NeRIWEI3Pi7	2019-12-19 17:34:13+05:30	\N	2019-12-19 20:34:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
E4tBuMX64DUH1h0d55v6FMhED55912LOj7957G56459fPtLDb61hfw6xkB6j	2019-12-19 20:47:26+05:30	2019-12-19 20:47:51+05:30	2019-12-19 23:47:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9Z1eI5Xud8O33c8cuTM81am5ZvddH3zLI0fY0aNvL2IL8z1u9a6c59a5Z4o9	2019-12-19 20:48:06+05:30	2019-12-19 21:28:11+05:30	2019-12-19 23:48:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	900985bb-b940-4c59-b11f-75413b3414d5
S5P25LVcyY7lf9UUQ7L625F3ya1gI8kcp6Rf956txCf0g8P535853cY3l3ew	2019-12-19 21:32:13+05:30	2019-12-19 21:36:52+05:30	2019-12-20 00:32:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
6cWE5OWVO0Fx2bal113aVfu4f9ATL86210b3Ap7p1291p1p05Zdnnf19Q8n5	2019-12-19 21:37:22+05:30	2019-12-19 21:37:35+05:30	2019-12-20 00:37:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	900985bb-b940-4c59-b11f-75413b3414d5
1a17931xeeVfLRz831Uf9MhDy99OM1k58999raykK9DfDmh6jB1cLaDlYfDp	2019-12-19 21:38:19+05:30	2019-12-19 21:38:31+05:30	2019-12-20 00:38:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
QVu11orvd3717efdR0711bitFp6i9pq8voRNj98vRpd5a9UFRpv0t1F1i51S	2019-12-19 21:38:48+05:30	2019-12-19 22:21:16+05:30	2019-12-20 00:38:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
6Ki3u6bZ6g9KB6xlja244u2lbS4ZC3SZ63A6ScfS0gb6wSgu2K67d1JMw97x	2019-12-20 12:16:28+05:30	2019-12-20 12:23:35+05:30	2019-12-20 15:16:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
vG9eb58O7vbW877F9HeC2f1t8f053b7r9055g51FdFWbOZ99480qeJtT35dr	2019-12-20 12:26:13+05:30	2019-12-20 12:48:42+05:30	2019-12-20 15:26:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	48739a8c-2156-4a51-86a7-520c09a737d8
b3k6QeB3fBeBZLnd17C32C2x5X404gurM4QZ7X6cpvTQ5171558odrd7d6xa	2019-12-20 12:49:00+05:30	2019-12-20 12:57:22+05:30	2019-12-20 15:49:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
beCZ0BN14hLaz23HnYD954z7b544mU5bCOhZwBYNHU7Ohb37fK67MbYn7T97	2019-12-20 12:57:33+05:30	2019-12-20 13:11:38+05:30	2019-12-20 15:57:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
c6VdUwL52Cwk7wDnb3w4WGmNwf55w62k67w5TQwYcCgdUTTf68wkL6cc7xZW	2019-12-20 13:12:31+05:30	2019-12-20 13:15:11+05:30	2019-12-20 16:12:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
c4oz47VM917a11I6U9CZ171caaq1thfQ9cZG4ZH7z73fIOC5qa885yOQ4a3Q	2019-12-20 13:15:24+05:30	2019-12-20 14:19:52+05:30	2019-12-20 16:15:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
6kKfeW11e22Oa8hf1AaVpES2R62ncf0DeJpMp8SVq80Q460S33VO96Rr5Y1f	2019-12-20 14:26:48+05:30	2019-12-20 14:27:12+05:30	2019-12-20 17:26:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	48739a8c-2156-4a51-86a7-520c09a737d8
Orrk4s5kCkkC0crEr53k2cJAf33bbE956c83Cfk61c56CceEgE6ZcaEo5bc9	2019-12-20 14:27:25+05:30	2019-12-20 14:28:31+05:30	2019-12-20 17:27:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
P47304rWu0855Pd30F1d5PW5KN9P5b9WSczVSlG555Vul4DGz7DEPA1j435m	2019-12-20 14:29:58+05:30	2019-12-20 14:33:15+05:30	2019-12-20 17:29:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6e6cae79-b531-4596-bcbe-4cc5522c1536
ttyt8VTOB3V34dVs6gfcb2Y4iYswt9u84cu5Oyt5S827tx9t9cM8BNdYe698	2019-12-20 14:33:28+05:30	2019-12-20 14:34:08+05:30	2019-12-20 17:33:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
23e1X5XC63dZj13i0CCrpiHT3NNxd0edr7I7qZu5u092ZKI6CJ9GjQHHc7aD	2019-12-20 14:34:19+05:30	2019-12-20 14:35:06+05:30	2019-12-20 17:34:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
4a4edE37Or1A5AZa8SaagAKwDY7G7gGV7kc8DJ77G4dlfl87tj7e3tAA958a	2019-12-20 14:35:21+05:30	2019-12-20 14:39:04+05:30	2019-12-20 17:35:21+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
8pCxJ64rdO848EC92Bf3kx2rv9dBOVBwB681f879zV892CsCzy526fc5V4A8	2019-12-20 14:39:23+05:30	2019-12-20 14:39:36+05:30	2019-12-20 17:39:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
g8VFWpeF1e31KKjEtAEc22944tt6NW49l8d56IY2s42Y427F46h9HNhpw554	2019-12-20 14:39:45+05:30	2019-12-20 14:41:24+05:30	2019-12-20 17:39:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
Tb3140cvPaBLP219ngr87rN17Hx7xP3I7dt68b50601187p76v6tN35sLp2c	2019-12-20 14:42:22+05:30	2019-12-20 14:44:55+05:30	2019-12-20 17:42:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6e6cae79-b531-4596-bcbe-4cc5522c1536
QX5Q8oNo5a5dWN3j91tQN97SgrdZCY7Q88I3v9d7f17uTGEB995QGsi1N05j	2019-12-20 14:45:09+05:30	2019-12-20 15:00:52+05:30	2019-12-20 17:45:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
341Mrv67ZzGv1ng8Z4vGlu8nzznsBnXUUBGvqUz3F3lqs2GGcf1dsT8l6A1T	2019-12-20 15:01:11+05:30	\N	2019-12-20 18:01:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6e6cae79-b531-4596-bcbe-4cc5522c1536
lGVf573u3FupK1g01jEHfK67414fHsfvZ6guvUfmHj3E27Lu7r1VPH67KZqg	2019-12-20 15:02:43+05:30	2019-12-20 15:03:38+05:30	2019-12-20 18:02:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6e6cae79-b531-4596-bcbe-4cc5522c1536
zxO8u2z6OhYntb74u2tAzE5h6dY0GuU45JdFq1qcYS4U59db53Suf57BYn53	2019-12-20 15:37:33+05:30	2019-12-20 15:53:09+05:30	2019-12-20 18:37:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
03Zf7les31185e2zW1ysy3O1di1gt10Qr28QXyasa848nf57iX63ffy32Qit	2019-12-20 15:53:58+05:30	2019-12-20 15:56:45+05:30	2019-12-20 18:53:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6e6cae79-b531-4596-bcbe-4cc5522c1536
1nBaDoIvv652cjc6NaloLJf5lLvVu3WBNth31wOBl1aoVi61kWI7oIulaNBl	2019-12-20 15:56:57+05:30	2019-12-20 16:17:34+05:30	2019-12-20 18:56:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
0NyUb5phVuSuByrJ6BTc67u19kJ965n83oi2b0sp3PSn6c2bRVVb1LV4693b	2019-12-20 16:18:14+05:30	2019-12-20 16:26:36+05:30	2019-12-20 19:18:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
jjwIaKdekIll8WeUp3dbbRke4ggpVlhIuoi9Nlf763nmppk2y4fbIIy8KaJ9	2019-12-20 16:28:07+05:30	2019-12-20 16:29:09+05:30	2019-12-20 19:28:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
5u5UGdS3Qd49bU336a5SOj60Kbg18J8b4ZHd194q5JJviJ11iv99vBJcU887	2019-12-20 16:29:25+05:30	2019-12-20 16:30:36+05:30	2019-12-20 19:29:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
5l5WVng67fZ81u8bf61Z17Z6Q255cOW1p8uV56u1oqNQ1o6pSXuf57i849mS	2019-12-21 15:24:48+05:30	2019-12-21 15:25:09+05:30	2019-12-21 18:24:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
2Tcf2226TSrEAc15c9dtjTdr5uNde39K85b2uTS9L2E88dbbKfKaSHwd54KT	2019-12-21 15:40:27+05:30	2019-12-21 17:40:00+05:30	2019-12-21 18:40:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
ae8Ui7nfdS9918Scc8YLkxefC98i5093nM2888ja7hx6e121G5DBLB8kh2H9	2019-12-21 17:40:14+05:30	\N	2019-12-21 20:40:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
0UkL8iP0392abQ97K5fbUe7ef119U195Rke9aUKIsb5a0EP80IH33MsX99dX	2019-12-21 20:08:17+05:30	2019-12-21 20:42:49+05:30	2019-12-21 23:08:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
19cr14017z33Bage1Bl8c4T7np65c5WP6edg1kkIKjE0dWh9a55CC5Ta2TEi	2019-12-21 20:43:13+05:30	\N	2019-12-21 23:43:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7WD6To7YS4DTdsl2D9d9f60cX45e6a2D7YpXXqg15eu6aw84064e6eVp472a	2019-12-21 21:47:47+05:30	\N	2019-12-22 00:47:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
5svR15M79kqw5Mk57vjV79aaR9XqdR1F7qla37pjllddXB72o6lqspqWLl37	2019-12-21 23:39:38+05:30	2019-12-22 00:29:02+05:30	2019-12-22 02:39:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
38J0vN5rY25bP0Y44kL416d3bpLJ791C4BmtY38mQ1kiY769Ti74e10C9vgm	2019-12-22 06:47:39+05:30	\N	2019-12-22 09:47:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
0eZ6tFId1wwkOAE7KoqF5WX4iZ03y4A3eceeV705q3t77uI54le391we70g3	2019-12-22 08:53:50+05:30	\N	2019-12-22 11:53:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
f859ou2hu8g9stut0lA33w0978925S17qZalfLZru3nffAaboJP8CXIdfoA2	2019-12-22 15:04:49+05:30	\N	2019-12-22 18:04:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
5453W07dk09eFu6QB45gjuWu2e04we7c033boq47we7eaB5e4qr53YeW7WH4	2019-12-22 16:31:02+05:30	2019-12-22 16:34:02+05:30	2019-12-22 19:31:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	f238775f-6e77-4df4-871d-7fb6fe8112b9
990zcB89BKEWEdrD9E01TDUDEZU8fB7wfZqKjz819zcRVfKtrD7K99KDX98j	2019-12-22 16:34:45+05:30	2019-12-22 16:46:26+05:30	2019-12-22 19:34:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
RaypDfZ3UY85h3rTz0rBDkr28Zkya6B33FQi0V4n33aL760d1kHpyQPWYBP5	2019-12-22 16:46:58+05:30	2019-12-22 16:56:40+05:30	2019-12-22 19:46:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
aI7fJQ7B14DWBc2g8587kMN7K54J7e2e5UcI745te1dfwBTf7Ch11d2Me5D7	2019-12-22 16:57:53+05:30	2019-12-22 17:00:38+05:30	2019-12-22 19:57:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	030c2683-8ff2-47f8-81fa-f05dd8657f58
Ufc5cJnOEBuJPuJ339y49Rf2617333h1iB52D5ZbeJJFX9p11xdZ99BPh2cE	2019-12-22 17:01:51+05:30	2019-12-22 17:38:20+05:30	2019-12-22 20:01:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	e40a7414-8020-4472-8669-767db5f90979
Y12l2ai1YY0Rf43RHRn6f7iYdd42583f2fO13l451Htl18j8t6k580iA5fQl	2019-12-22 18:14:22+05:30	2019-12-22 19:25:30+05:30	2019-12-22 21:14:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
dpad79DBD9mp4d5R87EG7hp8IdWBRNrc84R13g8AbavoWdm4Tdl9eW21f130	2019-12-22 19:25:47+05:30	2019-12-22 19:53:11+05:30	2019-12-22 22:25:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
cdl3O7DFw7l21qF7KRRQCC715qqlRPR516i5jaf1wFCwdxqOl3BXCD0n9KRR	2019-12-22 19:53:31+05:30	2019-12-22 19:55:11+05:30	2019-12-22 22:53:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
dbWS1642VCS2p75B200z4VY025JSBdJzW4Ip2CO93SpWBSfCc24f2Sa0dfGu	2019-12-22 19:55:26+05:30	2019-12-22 19:57:30+05:30	2019-12-22 22:55:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
fdY22U066s0U40Sbdsvb2dHsK4fC4627c707Ocq7kKYSKlKlJcjC1O6H0k2w	2019-12-22 19:57:42+05:30	2019-12-22 20:11:22+05:30	2019-12-22 22:57:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
pwH2f9l9959a9k1fGiSa77lpw9A815c57GLH7SkzS8tSG5r7pptWi2cApW5M	2019-12-22 20:15:27+05:30	2019-12-22 20:17:25+05:30	2019-12-22 23:15:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	003c8504-caad-4e36-a34e-a1cc54f9e4ce
hzpBoGH7dTrf952GpJ7B213217HbBud1u12ffzr7S1G1Jv5KyffG0E7U9S00	2019-12-22 20:11:45+05:30	2019-12-22 20:23:09+05:30	2019-12-22 23:11:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
60xFG2C5JxsG2Ku9Gd78BIBg5i6nu39dpb1i3DUQgG76s81GEpNK6GS6QKaC	2019-12-22 20:17:49+05:30	2019-12-22 20:23:14+05:30	2019-12-22 23:17:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	7131442f-54a7-418f-9170-0eb8c7fd30dd
f7Vcw6836whbuQO8gp5dH4w0HmcVC7SZo1gF75XVS8B7uHFZoS76HvX3Vm7d	2019-12-22 20:24:35+05:30	2019-12-22 20:54:28+05:30	2019-12-22 23:24:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
P17QRY20ss5FoD5sdR6b4F02cz8X0a27LfyD564z2Fs3v0cI73TR3YAgcoo7	2019-12-22 20:23:30+05:30	2019-12-22 20:54:51+05:30	2019-12-22 23:23:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	f238775f-6e77-4df4-871d-7fb6fe8112b9
hAl88vvH500S5dH52m9v2lHPcDqrDA22cavq001840v2vSun0vcUcS7q7Y4e	2019-12-23 12:42:25+05:30	2019-12-23 12:59:26+05:30	2019-12-23 15:42:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
29MyuZ1x7X0795Cz7R060329bo0X1eoBS6x72lbK66QB040Z0S8U13P6146g	2019-12-23 13:05:22+05:30	2019-12-23 13:05:37+05:30	2019-12-23 16:05:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	dc6e8456-7fc5-472d-adde-28939b3da901
7w2S6070W7Po08n2jq6j8mSH5i9P8757owk3Z7oQTdEUo3Vot5Wj0yjkdzd7	2019-12-23 13:05:51+05:30	2019-12-23 13:16:56+05:30	2019-12-23 16:05:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
JT00PhZf4PPTg04TA3f4iS7c0P4C1Q1hSuPP2g01414J07ob7cPUVEsb47uu	2019-12-23 13:17:07+05:30	2019-12-23 14:05:02+05:30	2019-12-23 16:17:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	dc6e8456-7fc5-472d-adde-28939b3da901
61qE861r9OW49r1ec1e59zHzYI0p74qGUuNu79WXMe40d9G40HncIhMd9G3T	2019-12-23 14:05:13+05:30	2019-12-23 14:05:26+05:30	2019-12-23 17:05:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
5RE00z5BiR7q7378Rt1875SRRee134FZJqt06z5K3Fzii78iqdhd2TiBBkTK	2019-12-23 13:01:18+05:30	2019-12-23 14:05:37+05:30	2019-12-23 16:01:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
pHVvcD17IYhhdU757328YUW3ef770cnFnLTYcgyFb1KvL13AI7y0L3IU2e41	2019-12-23 14:06:13+05:30	2019-12-23 14:07:30+05:30	2019-12-23 17:06:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
m2097dTg03v7wsde82N0s0swTdHP555NK0c6H68Ce5OdC77130B24OF0m34I	2019-12-23 14:07:40+05:30	2019-12-23 14:09:11+05:30	2019-12-23 17:07:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	030c2683-8ff2-47f8-81fa-f05dd8657f58
9J99AdLeBj0w0Agl1g03cjB8t7T91a76tnB35GRFm9v181Z30QJfPs5F2Oem	2019-12-23 14:09:27+05:30	2019-12-23 14:28:56+05:30	2019-12-23 17:09:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
l4JN78cY3n4YJ7u10aRmXc0ej6L0BJ5l58tqUIYhi1jz0k1aQJ8a46NfLyR0	2019-12-23 14:29:06+05:30	2019-12-23 14:47:29+05:30	2019-12-23 17:29:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	900985bb-b940-4c59-b11f-75413b3414d5
E2bNpN6ddmdCdHQE71ttbD5d7dYFFo11077075Hu505E67S5eH1p5Hp6Q80o	2019-12-23 14:05:51+05:30	2019-12-23 14:47:32+05:30	2019-12-23 17:05:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
3UgJ4213vR12WeH25e5FM390Sr631N9i71V54l12M64g9f0710nR11fC617d	2019-12-23 22:50:30+05:30	2019-12-23 22:51:08+05:30	2019-12-24 01:50:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
5ZuEz58e5c909zxV74359z7fcB25W7Zz7z775Scx01UW5c7bK87kGb7c21c5	2019-12-24 13:44:01+05:30	2019-12-24 13:44:27+05:30	2019-12-24 16:44:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
Rz2Yg2s0RR2MJ8ru9152Rl5R4h58blcl3MHg19vS585bM68F12F5GRC88MRG	2019-12-24 13:44:42+05:30	2019-12-24 13:45:54+05:30	2019-12-24 16:44:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
0v0031q7q35M7T57qG95BMJ9O07zBy6W0B5f4614c0405T0MWx5y4Z5W7To9	2019-12-24 13:46:37+05:30	\N	2019-12-24 16:46:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
5Ba15GuK009uOR91u4Rrr1u1bQQd9dKrO7ScO5Z47J1iQ5FH6R0C06o54uSc	2019-12-24 14:55:00+05:30	2019-12-24 14:55:34+05:30	2019-12-24 17:55:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
Q2dl8oC7EG74505K57u59uX59507Y6uF57xT752e85Pd141f7C78184PZtxt	2019-12-24 14:55:44+05:30	2019-12-24 15:02:24+05:30	2019-12-24 17:55:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
6V7646p673Z4bYYD1YQel1y7K5Vs5d7pE1e7Ab0lV4YUpw1Qp97gqJIQyc5s	2019-12-24 15:02:54+05:30	2019-12-24 15:03:16+05:30	2019-12-24 18:02:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	1d6ce7ba-7161-487f-b566-7202e9222174
YKzeef8dC0dWLi7KDCd9vd1l1XSJieM513EeC1114E1bn7ClLAd86191K5DK	2019-12-24 15:03:31+05:30	2019-12-24 15:31:54+05:30	2019-12-24 18:03:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
dt0D10G3072iad3Q656Y2dMfMmdA2vF0jwalpmD817J2bM822OGMa55uTkds	2019-12-25 08:23:07+05:30	2019-12-25 08:24:46+05:30	2019-12-25 11:23:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
9rf39d4Q1DddrsfTFf5Qff4l02QbB54Gex8XT2Tf294H0Plrf92f3Xdre152	2019-12-25 10:56:13+05:30	2019-12-25 13:29:32+05:30	2019-12-25 13:56:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
ze8N2Bs9wdNt855J380dEF83jT0EJe574ar2511e58aBhNaae8rHXJBh00zy	2019-12-25 14:43:02+05:30	\N	2019-12-25 17:43:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
BCQ34Td914ZO9737z5Tc5c6f5gbyO1WNWpbZ2P543TT82FZcrJpf53dH57cW	2019-12-25 15:00:37+05:30	2019-12-25 15:17:36+05:30	2019-12-25 18:00:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
6Y1952cEd9RgK38K4W13FEmecTgjG9IETF9cE761e200WGFKzK926V61e084	2019-12-25 15:46:32+05:30	\N	2019-12-25 18:46:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
jgw52xM5iMc2Yztg1BcMyx7gW2xxK3o9KWYyQ4ggyu2T8225OQ7Io4ejYoYW	2019-12-25 18:02:32+05:30	\N	2019-12-25 21:02:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
65m204U2kHjdoyeem5E5ZARCglA175EX0Mlmrdkqe7l1myi101vet1EeORFA	2019-12-25 18:32:25+05:30	\N	2019-12-25 21:32:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
fEc1OcMvL7G1GL6591c9g9676Av10P8H07717L999d786hXg5a9729Qa8H13	2019-12-25 21:36:30+05:30	2019-12-25 22:25:19+05:30	2019-12-26 00:36:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9A292Hn2lGo8G5K42r4398G5oUSl1NAlPm0pa1rINKf8a2i26X9Tx2I2996t	2019-12-25 22:25:34+05:30	2019-12-25 22:32:58+05:30	2019-12-26 01:25:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
TSXRD42857X233l3261ue4A9AbBXH7AX9f8sb3z2tfXu67TM7sTT4fb025AG	2019-12-25 22:40:18+05:30	2019-12-25 23:05:54+05:30	2019-12-26 01:40:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9d4m4hqdc5n425d4e5l5t33e98p2uZewRmZJl9A30Z3A8K5CRh3cL51nE5ll	2019-12-26 12:29:25+05:30	2019-12-26 12:29:45+05:30	2019-12-26 15:29:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
50531O4D46Vo0L51ssM3eX7580221L8355bh3w5oX0660h3h3P0401ps585V	2019-12-26 12:36:26+05:30	2019-12-26 12:42:04+05:30	2019-12-26 15:36:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e40a7414-8020-4472-8669-767db5f90979
T8J7MNXpKQ331p6b15vC1s3s7CCM7nRp6n4M105605MF4275vX47Q2bImvvm	2019-12-26 12:42:12+05:30	2019-12-26 12:46:46+05:30	2019-12-26 15:42:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	003c8504-caad-4e36-a34e-a1cc54f9e4ce
rfT06J5b658SWT9G7Dg6gJ51F0i3u74iFoQ4FIbviL7Qo0gK6LvAi08P3Tg0	2019-12-26 12:46:59+05:30	2019-12-26 12:56:20+05:30	2019-12-26 15:46:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
s9C2ry52T52L15YNm8845x95y5AF8x22N7Y5fjy68271A15Va92NW1qreTQ2	2019-12-26 12:56:32+05:30	2019-12-26 12:56:54+05:30	2019-12-26 15:56:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	7131442f-54a7-418f-9170-0eb8c7fd30dd
npInV4h3201xRM0Tk352RI7iV8171wJ7H2B22d1xypd5JLL1bLk5IHkyGijP	2019-12-26 12:57:25+05:30	2019-12-26 12:57:38+05:30	2019-12-26 15:57:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
w8XkjV4w13zLq4hAwGNhN335T14j5d01xlo47yz51NBqX4oo8V18wvabg2l5	2019-12-26 12:35:58+05:30	2019-12-26 12:58:00+05:30	2019-12-26 15:35:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
Ekd09Xi559H95Tl2571335p5z9750p59i050GX0ldg3GGl5T7a09O2TsjGTz	2019-12-26 12:58:10+05:30	\N	2019-12-26 15:58:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
k36HZ00Zs4uedpy1Ws7WK6tb31L2k43x507SW9xQx0sR13Wa21i945701s48	2019-12-26 12:58:24+05:30	2019-12-26 14:18:51+05:30	2019-12-26 15:58:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
a999VbL40B16qB2475UHen6805H90Og507567156BbHjR84j0Y1yba94obdB	2019-12-26 15:43:34+05:30	\N	2019-12-26 18:43:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
umhXudv148mdl2x5Z089ey57NeZD2c54W5boon241h4h55Nnhchkl5NDC78N	2019-12-26 15:46:12+05:30	2019-12-26 16:48:09+05:30	2019-12-26 18:46:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
o51wGi4T461rOd3vTde1YLL7oyp3T45TGf7Ac77s63Ol2oFp94e5Tvb3yD53	2019-12-26 19:25:35+05:30	2019-12-26 19:57:02+05:30	2019-12-26 22:25:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
4SShlh9dC9777aaOCz0re5ZW7x97h753ObN0Mxih5ZM37U5aFcuaVCre749b	2019-12-26 20:12:53+05:30	\N	2019-12-26 23:12:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
7pDG4f3888Q99X8q7aJt85JWQq399ZDaI7Iah5f03I085MDZnCC55l7NY44x	2019-12-26 21:04:18+05:30	\N	2019-12-27 00:04:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
x1E9Jj27B8Ja0816Bv55w5vJ16gPIBII781legveIeb46DIHmDIaWj3XH5Ji	2019-12-26 22:56:44+05:30	\N	2019-12-27 01:56:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
eSofa47sp35U40WdV1S5d7cvC905eaV9Wf0p7ctv5l65WfbT5Ha54pLqmX54	2019-12-27 06:47:56+05:30	\N	2019-12-27 09:47:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
dATwra1p0aEapN5PEe0diB9QTe9i6CTfmZm706MhF8T149ZEZCPAbM5066i4	2019-12-27 06:56:09+05:30	2019-12-27 07:01:52+05:30	2019-12-27 09:56:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
v9pcG0aw91d7bXwCvmIGAPr5He70537KNmv3Ef255cK797O0e96jPc9KPr9R	2019-12-27 07:02:53+05:30	\N	2019-12-27 10:02:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
B071OY1c5dOO5ozP76b450YlC7Y0u057ieSyY0ehHcbP46OLO1Yv1HY5NvTe	2019-12-27 07:24:37+05:30	2019-12-27 07:51:44+05:30	2019-12-27 10:24:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
a1G757J8TnGm8m3Im5n0TGX7EWg5EdhC54NTGpCHEcv111QXxEGGxzlea22b	2019-12-27 10:03:58+05:30	2019-12-27 10:05:11+05:30	2019-12-27 13:03:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
u88vaDT572j0A82la80tQ33X7ZnT2P85DnXY796NcBtD7089B0C4uQ0Ukc79	2019-12-27 10:03:26+05:30	2019-12-27 10:06:53+05:30	2019-12-27 13:03:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
jg60T373g0hSe7Dqhe2oT1e1XoR810u52h45eP102dF5A0508ogKnaeounhe	2019-12-27 10:05:25+05:30	2019-12-27 10:07:19+05:30	2019-12-27 13:05:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
abB875f57teeu90m7i8xOBehc8EdddS8Ubmu8i506d13H95UuKaU4qb9taju	2019-12-27 13:28:39+05:30	2019-12-27 13:31:03+05:30	2019-12-27 16:28:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
dqEq1yWlEc7l9TS9EK5C0O67235a33a1tVe3GE4O65GqW5MfK5W51hJMgb35	2019-12-27 13:31:15+05:30	2019-12-27 13:35:42+05:30	2019-12-27 16:31:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
ia5NH53zih6C517i7Y5bd57FN44E43W444g3Y44C5X2KACN58e4a92fEs99x	2019-12-27 13:35:56+05:30	2019-12-27 14:01:28+05:30	2019-12-27 16:35:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
OdRsJ9U1mG0WO95C907xB5nC746dj43e77291579bJB01117Ab3FY42noxw1	2019-12-28 11:55:16+05:30	2019-12-28 12:36:14+05:30	2019-12-28 14:55:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
U51972Of5iO1mR59E07U3ZR7142v197LRV1377k1W53VeRe1SvWnfk17FlKe	2019-12-28 18:18:37+05:30	2019-12-28 19:01:05+05:30	2019-12-28 21:18:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7GxX5OEL57U052BGeqiMo0LDb7P498mD77PVmG5bo77D07707NQUn315OI7x	2019-12-28 19:19:05+05:30	\N	2019-12-28 22:19:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
bgh69J7N5aXu9Jq0Gep5ZaVq5H178F86NDe82ehZ47D7gneXnG0721vd59Xz	2019-12-29 08:32:18+05:30	\N	2019-12-29 11:32:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7X7XXjY03jXjbXXN39796Xc6273Nni3454575A07Pb1AAnwH1fe8208776Xs	2019-12-29 12:33:13+05:30	2019-12-29 14:20:34+05:30	2019-12-29 15:33:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
8mL416m567YR3236Y9q23X1K6Bq3qAPqVmg7Sim96YM99rzs64KYqsVx2g31	2019-12-29 14:20:49+05:30	2019-12-29 14:22:26+05:30	2019-12-29 17:20:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
g6t30i6250545s5P77P02qTln05Kd45bg941Vy5Ki9ii7yg0i90t561Vzy0V	2019-12-29 14:22:35+05:30	\N	2019-12-29 17:22:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
56P679a14l66mQAX1Wff94ej4X5gafve5ZM5u5pib0Z8gY63F4345P862GgB	2019-12-29 16:17:25+05:30	\N	2019-12-29 19:17:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
5aDp71663PPXIVt7LL51P01J5k7L88c8Yl1p1Le91L39I62sZdZ51272ns72	2019-12-29 19:18:18+05:30	2019-12-29 19:20:00+05:30	2019-12-29 22:18:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
e3aX0jLL187GM246bKJ8Uh6qF181AkDA3hGQHL4a7cQ4ZZzVNNxNNZkG8Mcc	2019-12-29 19:20:19+05:30	2019-12-29 20:31:20+05:30	2019-12-29 22:20:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
b3jrw308g7oj0abc0AGwr81jbr6G1g3bgHr15TIf56Gw1f0aT6549kogadmm	2019-12-29 20:31:42+05:30	\N	2019-12-29 23:31:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
Qv77cYd4ww2aSJz37HdX77GQQ6JCa7d5cZyi5caM69dMdc7a6PHd27a8wBHF	2019-12-30 06:50:39+05:30	\N	2019-12-30 09:50:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7zbEX1H10l0Mf7x70lN95LZzkbc0603ZbJJ1EA11x016Tl19zkoE6Lb19oz9	2019-12-30 09:52:47+05:30	2019-12-30 10:11:37+05:30	2019-12-30 12:52:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
7PWUbJNgpDhpgas2fl6s71606n87J7D7zB4mBB6BPb146J51u66577Cdng8u	2019-12-30 11:52:56+05:30	\N	2019-12-30 14:52:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
b8q02229SQY9VxV9G07qjUfq7e30cO7ScVo0Sa9m08By01aB87cKYmw1SD89	2019-12-30 14:52:52+05:30	2019-12-30 17:31:31+05:30	2019-12-30 17:52:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
E9u52Ki1vZ4711e17MuKe1U114yKe7Z9WAbK3880oy8ge08E68Zp60775SgZ	2019-12-30 17:31:53+05:30	\N	2019-12-30 20:31:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
27Sy3f01Q4Q7ea4ohgp1LT77738S6A103z20XnT76gfHE7Fh83qQ6Smeu6ng	2019-12-30 20:57:12+05:30	2019-12-30 21:44:37+05:30	2019-12-30 23:57:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
225Sx1E9xGOG0T0b00GGMANja05o2Mb0W250KY2351SYO1212b9adQ376221	2019-12-30 21:45:59+05:30	2019-12-30 22:10:43+05:30	2019-12-31 00:45:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
KfcYv9sGvK88oZ87h3Yf7GF8170Y0o7ZGDJwePdMc753MjhpvagUJ0ja0ca2	2019-12-30 22:11:12+05:30	2019-12-30 22:13:23+05:30	2019-12-31 01:11:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
nURMfbKgfb002JSemO4dF3t3R80KRBcx2C4b847MXj1e00E0Ejd4fK8yyjfG	2019-12-30 22:15:47+05:30	2019-12-30 23:15:40+05:30	2019-12-31 01:15:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
cy7QbxQRh7FfIjsT7t67Mj7gwUsx5JjI79xg269egm6xRT7mgetfTSD4awn8	2019-12-30 23:15:53+05:30	2019-12-30 23:25:19+05:30	2019-12-31 02:15:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
R5Y1VblSaE79ExNa69I5ovd31535JgnooIAiRaYv9Sdnn77797375vATavmz	2019-12-30 23:25:37+05:30	2019-12-30 23:38:10+05:30	2019-12-31 02:25:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
4z91i51U0FpvUEbHd1m7Z0t3p5hlavz3vG0s0Zs7272a55UZRFlbmzze7e9d	2019-12-30 23:38:30+05:30	2019-12-31 00:10:23+05:30	2019-12-31 02:38:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
Rvql38vqhC2r0z2Uw3v736W4Jw2wi772PliFQv18RdlG4Glx8vG06V7L83ex	2019-12-31 11:59:42+05:30	2019-12-31 14:13:30+05:30	2019-12-31 14:59:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
V95b0cV7j652V0l8Y0eXOs7T9270Q45wxntV9FE9O7w94LTnVd7sj0lYW7j8	2019-12-31 16:27:09+05:30	2019-12-31 16:28:45+05:30	2019-12-31 19:27:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
P23bjOO925ef7WfS0WpO3b7D14SA6dO8k77iPUz6356buS0fseS66QkT3D03	2019-12-31 16:28:57+05:30	2019-12-31 16:31:09+05:30	2019-12-31 19:28:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
m7f1J222g1T87fy5u1KAaz7Kf100UB11Tibu91aGpy171gCeU7K6f704C714	2019-12-31 16:31:25+05:30	2019-12-31 16:31:33+05:30	2019-12-31 19:31:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
4bTlGT0Ee3uH9eGf7fpmPGLx1bV8q4eT6q7iGgenI9qUe6Gn723S9e64ONiq	2019-12-31 16:31:44+05:30	2019-12-31 16:31:58+05:30	2019-12-31 19:31:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
bmcAIa0eyt0769Dybjq95dpt00YwYS1pc5z8qzD8h0xjy1Jx4d15IxdAb5p0	2019-12-31 16:32:20+05:30	2019-12-31 16:33:35+05:30	2019-12-31 19:32:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
Rlb4404p73zdHp491NN0YKlbdK101K5xK2z5Ob2ajae7blujzv114uj6e0Tj	2019-12-31 16:33:51+05:30	\N	2019-12-31 19:33:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
3E7up6iM32hal2x0sZkQRbaZ6zRlh0U7U2S47Y8600dqmM1l6Ku6LQ4ZzRUe	2019-12-31 19:37:46+05:30	2019-12-31 21:06:14+05:30	2019-12-31 22:37:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
g6d81ddFg568b0885c5e3a25neP5q8v9Ggg0fg756v3777kc8a7e56o5fgLq	2019-12-31 19:42:26+05:30	2019-12-31 21:09:27+05:30	2019-12-31 22:42:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
3S3ajE8OzBTpjcnsjsL4s4s92793jjzbepvDv087tUc7LH72eHXfHjnU48nh	2020-01-01 07:12:17+05:30	\N	2020-01-01 10:12:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
6c1LW5f4CY7i7W85eb8A4wAN3y16r6QPy1YqP1fwbm4rA2W578yyKBf18YaF	2020-01-01 07:25:22+05:30	2020-01-01 07:37:59+05:30	2020-01-01 10:25:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
7etW123ffooJ88I8t969r3fy282J9XBWY78r20B5uqWw8tW18owa29XJYV38	2020-01-01 07:38:33+05:30	2020-01-01 09:55:11+05:30	2020-01-01 10:38:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
32w28W80g10p03xRGWCW127Gxqn235k133e60wY636KoGqV4e1K0cp8X2mbX	2020-01-01 09:55:23+05:30	2020-01-01 10:40:47+05:30	2020-01-01 12:55:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	e0574765-71c6-4a9b-ad0a-1d9ab8772148
DO875n26OKZhh078Yn7357A9Un033618I68ViVXM5Th0F7aDe62IgA8g2274	2020-01-01 15:26:07+05:30	2020-01-01 15:47:31+05:30	2020-01-01 18:26:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
bu08Zy6y6cm8yar58q9r3has0F33U7e09jgcWbFrUuf1qgJ0945f2B2jd1ww	2020-01-01 15:47:43+05:30	2020-01-01 16:13:21+05:30	2020-01-01 18:47:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
zcNc6nFSb7ed40avE0dC7q856yxI585Ndd1ki0dF1O54d7g6sa78370b5Vq6	2020-01-01 16:13:31+05:30	2020-01-01 16:15:24+05:30	2020-01-01 19:13:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
N5E3TH4U5TT5Df9eRMh87670667Tps566id67Ul4CeU7E1R067t383571D49	2020-01-01 16:15:36+05:30	2020-01-01 16:17:02+05:30	2020-01-01 19:15:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
0CY315YGq87qq293bG1bd7sqfY888576b71dS8kmbY3E30sGSm1L3K82stx2	2020-01-01 16:17:13+05:30	\N	2020-01-01 19:17:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
c1KJGLw69Ir0tZSHF0OzG7qO121G576Okqrwv7b68816OxJ81vncSaGF7nr7	2020-01-02 12:13:06+05:30	2020-01-02 13:29:01+05:30	2020-01-02 15:13:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
xNQeBOR0kdPaAr1OAoROf0X3PfyR42zzP9Ou7xK620d9QM4x9830Muy56U88	2020-01-02 13:29:14+05:30	2020-01-02 13:29:55+05:30	2020-01-02 16:29:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
6A45VhAU2Wpt01MV2Ep05f74872G4eG8rw295E1A20E65MXEp2Nx3d0027V2	2020-01-02 13:30:02+05:30	2020-01-02 13:30:40+05:30	2020-01-02 16:30:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
ISufi69277c119d7Vv98vd3r0u5f33Fa230R1e8fd2F6bAuV00220a5e52u5	2020-01-02 13:30:50+05:30	2020-01-02 13:32:28+05:30	2020-01-02 16:30:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
8HSyHHqacVH8hcGzCZCH9RLpl90gu17GxB3xuCVOcaCOppa5BHd1178u3135	2020-01-02 13:32:36+05:30	2020-01-02 13:43:18+05:30	2020-01-02 16:32:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
yCS7ffJ0KPi4GM5Q85S000Qir57GcRV5fVri830qgt00cGM00NGvEfJag1Ef	2020-01-02 13:43:32+05:30	2020-01-02 13:43:46+05:30	2020-01-02 16:43:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
dsFYwW9a7y4Gdx4yL4O297RaLsn2GWW8a0JOz29YDs7hm4aAnO8J7Y0173Od	2020-01-02 13:44:00+05:30	2020-01-02 13:47:32+05:30	2020-01-02 16:44:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
BL727Qd5l5SBL119RO0lTan19SB75id8r376l5r5S263S6J57E73q9flT5n9	2020-01-02 14:33:19+05:30	2020-01-02 14:34:00+05:30	2020-01-02 17:33:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
7993hw3915O69C41w73U8Q9Ik8uLNaM9hU9j26aC8i5OeLy48aU58a1Q0aAN	2020-01-02 19:41:28+05:30	2020-01-02 19:41:50+05:30	2020-01-02 22:41:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
5b88hCT1893hQTxuCM7LT31f5tQV9R13VV7d7b987R1bT9c4Vhb9YR0M37y9	2020-01-02 19:42:07+05:30	2020-01-02 19:49:51+05:30	2020-01-02 22:42:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
MqvAIkRJc4f84eTbi7rz39Fb4A6up3LqT854JRG71qNeziNxTT74ut0I4tN8	2020-01-02 19:50:04+05:30	2020-01-02 19:59:05+05:30	2020-01-02 22:50:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
25jFG7Dpu74b5582bi5dge4dfRhR1u6jKvDtRzYb9Ri9i25q1hiaa527K086	2020-01-02 20:01:54+05:30	2020-01-02 20:02:00+05:30	2020-01-02 23:01:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
a8J6f550Z7X12a7947s86W7RW67nCJZoSfnB9W9dSGKdt69c7aJJefJ62J6b	2020-01-02 20:02:40+05:30	2020-01-02 20:03:07+05:30	2020-01-02 23:02:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
PYw2Yy3xd21532hfs430YtDP50k0NiZjE2X9NzFDyX8cj9tXtfPZQ3aDZ43Y	2020-01-02 20:03:18+05:30	2020-01-02 20:05:13+05:30	2020-01-02 23:03:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
9658aEk55Or4E56DpOR9as6u96169Mjd3hK71Opr3salV2a7KaPE0duh154r	2020-01-02 20:05:25+05:30	2020-01-02 20:57:37+05:30	2020-01-02 23:05:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
zMA82v788dbEdcgd02n810RoV7175V0Ad4vbi25e0bl98R1vb5d811Wfd41r	2020-01-02 20:58:00+05:30	2020-01-02 21:08:58+05:30	2020-01-02 23:58:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
034t1Mp9RldrB5e60910ZB21k9H803Z3lap8yJpZbX33bMkJB0BRryB9r70E	2020-01-02 21:09:23+05:30	2020-01-02 21:42:47+05:30	2020-01-03 00:09:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
7e5yCnGRcC5aM7l0MZ90mPt0v6PU86cR76Pv50Rh8Nae8Me8S7eM098t0ieC	2020-01-03 08:29:18+05:30	2020-01-03 08:30:51+05:30	2020-01-03 11:29:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Hz79a9R0A5MyC5E695j29ycW72Vf2B0eq5333f8mA8yyR6ZVyVjz1V00X7XM	2020-01-03 08:31:06+05:30	\N	2020-01-03 11:31:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
WHaecep2Cv2odQr215H3UaCkN0pLJ90eRrYXhW5g8yHUt00Hnqor5n52YRiC	2020-01-03 11:39:57+05:30	2020-01-03 11:42:15+05:30	2020-01-03 14:39:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
R3v7U17io72A7EJiKof8oE273JxsH7AH12F2o07hT28J8yj2iUG2787nK7jw	2020-01-03 11:42:40+05:30	\N	2020-01-03 14:42:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
39ua5740f076p1JZcH52p4Z3KX517j15eeOvPY45PcEcU9558861e3LcY207	2020-01-03 12:21:17+05:30	2020-01-03 12:22:49+05:30	2020-01-03 15:21:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	1d6ce7ba-7161-487f-b566-7202e9222174
tbfZe25rQYerbrfUI40eB4tq5ehZD6YQ2eDL57eZHlBfr67HsD3GHYfdG1Z1	2020-01-03 12:23:05+05:30	2020-01-03 12:23:47+05:30	2020-01-03 15:23:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
p7I00D36VoYpEAZo8f9lA5Y8c778ZJ8Z55DcD8Tpf0EuN09Yr484h8n46Q8e	2020-01-03 12:23:59+05:30	\N	2020-01-03 15:23:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
di5DNeSafM58S1Mq1SZ514is71e3N5514rxU7zMnMD55M8x31s767o1yq545	2020-01-03 12:26:03+05:30	\N	2020-01-03 15:26:03+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
g525md7t4R1Xb7vam5ugvQ5616RaFa1668G3Gfaie5dG02LEmlj1S1sabi5X	2020-01-03 12:27:33+05:30	2020-01-03 12:29:49+05:30	2020-01-03 15:27:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
jq104P6QR85WLe07fQOe1130eh9A8h6AVa4RuAAV5f77k0WTEl6N8fZfm1B6	2020-01-03 12:30:10+05:30	\N	2020-01-03 15:30:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c039de78-d396-4156-94ef-11f67c5991d9
d5q15A437q88Ou4CceI48LgbiKKWj8jd9exI9U8gd9eMOg10lXe97oeTqcf5	2020-01-03 12:33:38+05:30	2020-01-03 12:34:03+05:30	2020-01-03 15:33:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
x78E76735J7M33E9OVm9eYMt559v9te05MvYt7F354WvFTO09FDFNmFnZOE8	2020-01-03 12:34:23+05:30	2020-01-03 12:34:45+05:30	2020-01-03 15:34:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	1d6ce7ba-7161-487f-b566-7202e9222174
J2k5RW39z1Re8J285883w63871c5ed33Ae907jja8r4Y35jZodoF789JuWYw	2020-01-03 12:35:01+05:30	2020-01-03 12:40:38+05:30	2020-01-03 15:35:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
e8ee06uFZPeUeb11gxjk5gLZ6079e00FaSa629D972dGIiuPuzi4a0a1GY02	2020-01-03 12:45:39+05:30	\N	2020-01-03 15:45:39+05:30	192.168.137.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	900985bb-b940-4c59-b11f-75413b3414d5
3rRv4S664NHCew22Fc0sd5ZB1e54rcOT1cKKtc56t75wI0MzLtR4KKtee596	2020-01-03 12:44:21+05:30	2020-01-03 13:10:54+05:30	2020-01-03 15:44:21+05:30	192.168.137.47	Mozilla/5.0 (Linux; U; Android 9; en-gb; Redmi Note 5 Pro Build/PKQ1.180904.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/11.3.4-g	c43846c6-69ba-4161-9f06-a5f801791796
e1M0U4OH9z3Z8L47538zO546Mf3r757bjQNo32YxHK7Kecz7Cl00OHK2KKZM	2020-01-03 13:25:05+05:30	\N	2020-01-03 16:25:05+05:30	192.168.137.102	Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36	c039de78-d396-4156-94ef-11f67c5991d9
gpuP0gfG0J4JgC2ev8a0zHA805Tj9Ggf0Egf07uag6r0K4D41Ac9pG709S51	2020-01-03 13:47:36+05:30	\N	2020-01-03 16:47:36+05:30	192.168.137.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
pUzfL052I55wFd61SNzLW0F5BReH15N59j5E007K9LNB7PFHUU6Le7Ha8657	2020-01-03 13:53:41+05:30	\N	2020-01-03 16:53:41+05:30	192.168.137.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
xaDM2eeLJs1TqfuPT0fWqvn1P813NPfFQELlb212u3k0xUX1FP0JZ1e506eN	2020-01-03 14:27:08+05:30	\N	2020-01-03 17:27:08+05:30	192.168.137.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
a6ef5t8V64WH4aA87KGdN7e4yl540l9dxLGA1xe5a2mmegGy6R56n266OWeB	2020-01-03 14:41:35+05:30	2020-01-03 15:12:09+05:30	2020-01-03 17:41:35+05:30	192.168.137.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
4qfgAPeT1alVX0Xfq13569O0y6T79043OT1pe5elVwTT7F3VK1T01pFAuKBW	2020-01-03 18:51:08+05:30	\N	2020-01-03 21:51:08+05:30	::1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
ZcXuCzmA450DMt7L0k4zA9D1dmRMk6ZXu29c6fd4tX426dXmtI9cL0NCA8XJ	2020-01-03 18:55:47+05:30	\N	2020-01-03 21:55:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
528fscas8xJH65m062bPmm5TxBs28F11F78mGpWW26x66x8e7V0sI8dGKWVZ	2020-01-03 19:45:16+05:30	\N	2020-01-03 22:45:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
yk4kMJ8nk90n5F67VRe17AjcddJvRnSQFcA0IO7djvT79k001gMRM29cxRcI	2020-01-03 19:45:34+05:30	\N	2020-01-03 22:45:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
77KA0Ft7m0PfU6d5QDV1UmXm5Sr8KV2mUKPULf3rrtU6YmKMU25540dB310A	2020-01-03 19:58:28+05:30	\N	2020-01-03 22:58:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
uH527P8Nqy0MB4H4UE2287jOgzy25PQH9aS8yz11O5E44a1uP7Taf58M7VNt	2020-01-03 20:24:54+05:30	\N	2020-01-03 23:24:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
9YA057VwB2cfehMOwDf1a7L5igwQ5ecQLu0B1wqJ01bw5MOLff4M6UbD1M89	2020-01-03 20:28:28+05:30	\N	2020-01-03 23:28:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
8H8774pm3NmTcE5off0N8Co5r0dZOt8Z5CNBCqMWr8t2Tkq2B8Wx5593nhnp	2020-01-03 20:30:59+05:30	\N	2020-01-03 23:30:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
u0dA2AdEh4zZ97c4c5dEd645e4Or9834c6y6c70uu6E5oFmbh8c8a5c3bg53	2020-01-03 20:31:17+05:30	\N	2020-01-03 23:31:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
F3MBiPfv907kyF7OM500ia7g8c9f3v3NcStiJt655ggN7Fv5T5fjct5df3gu	2020-01-03 20:35:59+05:30	2020-01-03 21:03:46+05:30	2020-01-03 23:35:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
683UAQYG7CcDh1f85Y1wR6x5c51U4MocU07cr6Tt4f5DbWfUE9DDw6550S09	2020-01-03 21:04:24+05:30	\N	2020-01-04 00:04:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
rR56g9r18oqLffHpWd61f2xx6kQ921SJej7Z233lY4O6f1O06QbcfWQMS28l	2020-01-04 06:48:19+05:30	\N	2020-01-04 09:48:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
49d38SJZ25RN1711S3oxb7y199qE77w99N3L5I091oT1937m1JRZk91A29O8	2020-01-04 12:09:01+05:30	\N	2020-01-04 15:09:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
xqO38eIv1eLtee1L9zmE3649t8e1tN27b6Sgaq919j555CNtOhPn1te5gxxP	2020-01-04 12:31:12+05:30	\N	2020-01-04 15:31:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
XViyJ3Z78Dee51Zi559t58J28q838m837JN00VkEi06eYTTdZ340T8825095	2020-01-04 12:57:10+05:30	2020-01-04 13:59:40+05:30	2020-01-04 15:57:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
e59HXdffHGDeW8lbDfHk2Vc2D1GHODBf483s7Wei5M4e3Z22qOe9N10511FY	2020-01-04 13:59:50+05:30	2020-01-04 16:39:52+05:30	2020-01-04 16:59:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
mqe53L85v6lC8RTfw8a3z6165KzAZ7481qb8DiT85A68TW1Nx0ZapbmT8LN8	2020-01-05 07:13:35+05:30	\N	2020-01-05 10:13:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
Usj8We748E3Es4D9t8EsL82d4ki9Ek44A7011889keJbPjkF3mtO8Nsu1F34	2020-01-05 07:53:55+05:30	2020-01-05 08:50:38+05:30	2020-01-05 10:53:55+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
3OC9CFAM047k31en0Al193V5D1n3944dR26Vmm913h6dMO704R0sSfV4W1s9	2020-01-05 08:51:37+05:30	2020-01-05 09:11:03+05:30	2020-01-05 11:51:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
41kV13tsvl3Fc1UM552P129Y15V5qi5VO71hgh7ez1LY7r01a5fh57Y8391O	2020-01-05 09:11:40+05:30	2020-01-05 09:51:41+05:30	2020-01-05 12:11:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	c43846c6-69ba-4161-9f06-a5f801791796
geSPp0e944U974vS885VOW57epAepN8X5m4mj1TW9e018U111944719WqDqM	2020-01-05 09:51:58+05:30	2020-01-05 12:23:04+05:30	2020-01-05 12:51:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
H1yF1MCrSjn938n7uq2bqj1yvd1a10297lPOjPpM5I16uIu1uC2w90Cx98Dx	2020-01-06 11:56:07+05:30	\N	2020-01-06 14:56:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
R570L527lJ1R0t5l8L5Et959l105m84968tl94kPZ37X8gR2fFzVeRz81p00	2020-01-06 12:52:30+05:30	\N	2020-01-06 15:52:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
Kdb9e2ilLA6i269yb86b3U05fuFy0eW0lS9A9bU679d2sdU11Dyd2qeK9Qyy	2020-01-06 13:06:09+05:30	\N	2020-01-06 16:06:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
p6l852B5a5rs3TQ06mMlQKh8m3OMec3N3w73z4V9Tih1BeA9h7N7EwpvmwW3	2020-01-06 18:35:31+05:30	2020-01-06 19:19:04+05:30	2020-01-06 21:35:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
by5nS3pCmp2E6S0SJXE8NjyId5e3mOeN3Sen95v75jQO9b758fQv8mbCmjtv	2020-01-06 19:20:39+05:30	\N	2020-01-06 22:20:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
1B0Y4wR632NaaDWtORtRGD6RN2cKy7Za52118L970RY3E01tcIKLor770K89	2020-01-06 19:26:40+05:30	\N	2020-01-06 22:26:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
dA1J1H0fdfPPAH0PPk711413HA0gJE10JkLH31hl1Lflo1Z13fVOc33f8d4J	2020-01-06 19:31:53+05:30	\N	2020-01-06 22:31:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
RElRe2152r53B71533dIQ5lA8rEh2dw8ndZ88UwyU5fW91Ayw1l18r5yUlBN	2020-01-06 19:32:23+05:30	\N	2020-01-06 22:32:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
eu0r50t3Gj34OT07n1O7Ttra834HV5T5bq8mLwa34zrM75HK96375rHLke1T	2020-01-06 19:32:50+05:30	\N	2020-01-06 22:32:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
4X141eS19derxEzE0Kl4wsK73Ex80d01ofBd2dlz995EolMe1luW9S1Pe35u	2020-01-06 19:36:44+05:30	\N	2020-01-06 22:36:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
CagO1x1OtIa51a4TR47NuDg54rCeE52qeM37k1Fh143bNt5f81D47E1D0r2O	2020-01-06 20:01:23+05:30	2020-01-06 20:27:54+05:30	2020-01-06 23:01:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
f436hW14S3465vP5OAZiZ4fjMahc1714b2LZ35U6L3VaC5cb4DUgb44H4ahv	2020-01-06 20:28:12+05:30	\N	2020-01-06 23:28:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
pN9l7FQu21i9N1ym3kuMmmnaMQ1PlM517e891kDuey5eNuM5gI9gnn1TH177	2020-01-06 20:56:16+05:30	\N	2020-01-06 23:56:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
1W4TzW1y2j40f6wwhi66w34b8ee1vhTezcc2hwp39hjwe396116134vQ2245	2020-01-06 21:58:56+05:30	2020-01-06 23:05:53+05:30	2020-01-07 00:58:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
87VMGt2jItnt5MvI9Q564LB5717Vz2YF7Gzz554Sb7Bb1MU477Z7Q50b4114	2020-01-08 10:49:18+05:30	2020-01-08 10:49:39+05:30	2020-01-08 13:49:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
32x18U7xo1iO409501UaL830j50310GizinGFO0cnL6e7F40m0x7itvatoxx	2020-01-08 10:49:53+05:30	\N	2020-01-08 13:49:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
30h8TnPQ8N56701bb6h8hhVy1IMY1n6618I9otUf8ihY97OhyOI353hyV156	2020-01-08 10:54:29+05:30	\N	2020-01-08 13:54:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
Bzp6cj9798apwE5vO00qRoRN00ae58vtRLBH8Jip1qse1Re3aS81Nt0Nnca1	2020-01-10 11:42:30+05:30	2020-01-10 12:51:16+05:30	2020-01-10 14:42:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
BBN4mB7bf0MMFfNvKZAO5L10KBBT9NQ50yd71B8FNOfn47O1zNKU1B6a6740	2020-01-10 12:51:46+05:30	2020-01-10 12:52:07+05:30	2020-01-10 15:51:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
6Z44O44MiO86dF9t5Axk1W66t5tY10G62r5O4U9Yr89I924441is9kFYEI5b	2020-01-10 12:52:21+05:30	2020-01-10 12:52:26+05:30	2020-01-10 15:52:21+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
1A3f087YRA3QW34O0392794RY01qx7p35Z4128d340E040MoZR808xA5951z	2020-01-10 12:53:03+05:30	2020-01-10 12:53:20+05:30	2020-01-10 15:53:03+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
66UU7G1V8g76GGIg0kZI8f0yc6g0gUBIo97Y5ZwxZ5UL855PZB361Pa1s68E	2020-01-10 12:53:27+05:30	2020-01-10 12:53:39+05:30	2020-01-10 15:53:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
06H6W7T1Eq1x1T5eL4D59Jy9IjyC8xH5QSV598yhdy544ze3L525dxeh0846	2020-01-10 12:53:49+05:30	2020-01-10 12:55:04+05:30	2020-01-10 15:53:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
e5652jd1aXM2Fyt82M961LY6R8z23422z7s3Md21aFHAexZe5s45t0peLDKd	2020-01-10 12:55:25+05:30	2020-01-10 12:55:50+05:30	2020-01-10 15:55:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
W5KM81n6e40nAB1c05M45NJ4v18njd901118eAMl8vw56KqG4Mv6MK411c0W	2020-01-10 12:56:00+05:30	2020-01-10 12:56:57+05:30	2020-01-10 15:56:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
C8Rsy1T12N1eFt0h7865z20zcJhnz38AHTCjd00UX5t0P2nQFY0zU220r82t	2020-01-10 12:57:08+05:30	2020-01-10 13:01:46+05:30	2020-01-10 15:57:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
9OJL6E8NN1883SC3C7EnDCdS5wA43tWkaHda7o3OOKIH74R37NJRHLc7tQyR	2020-01-10 13:02:13+05:30	2020-01-10 13:03:20+05:30	2020-01-10 16:02:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	dc6e8456-7fc5-472d-adde-28939b3da901
e40r85bSw1qpb5dD5d4XGGpE58dUd0772HqgpQl12p9c7GGde18eL155e687	2020-01-10 13:03:42+05:30	2020-01-10 13:04:13+05:30	2020-01-10 16:03:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
L537MLG53m6061IOgce5idP7qztF75PS7Ude7967Le7F90q02729PIFU0180	2020-01-10 13:04:31+05:30	2020-01-10 14:04:50+05:30	2020-01-10 16:04:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
HmV7Velye09k55o38152kortDYU82Md3caFF24fD0d40mjRakeRyjkD4U48a	2020-01-10 12:58:22+05:30	2020-01-10 14:05:06+05:30	2020-01-10 15:58:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
641xe5p607L59a42X2GdXh86eif1f74XXh2aSV28iD2EV7m2Vaj8aXGcc6HL	2020-01-10 18:14:28+05:30	2020-01-10 19:22:54+05:30	2020-01-10 21:14:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
yd1x37J779858xw8xpZ9ZMw47ynf8Lt6jZsbRby3JF7f481159Z6573pZJ98	2020-01-11 18:00:09+05:30	2020-01-11 18:09:43+05:30	2020-01-11 21:00:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
3M0ydf2f68jApRCUH33q2NckvapBo72McCwdeo16B6RDRt7vHv78s9M065Rj	2020-01-11 18:17:27+05:30	2020-01-11 18:33:28+05:30	2020-01-11 21:17:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
d10z53yziKs89878956sDp8ei9S9u4e87pvnHSF92JF17y2BG57xczPS9777	2020-01-11 18:35:42+05:30	2020-01-11 18:49:41+05:30	2020-01-11 21:35:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
QX2n5AdZpaTTklE8kwdT1m5Ide4rzLF28Lcn9M2dsAGMzzsGrqvF1eXo7l9E	2020-01-11 18:51:49+05:30	\N	2020-01-11 21:51:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
G1VB8haGuevcV73P2P8SH732g51u7518B1lP836312ES6Xv5vBe77Mta9bv9	2020-01-12 09:21:08+05:30	2020-01-12 09:52:23+05:30	2020-01-12 12:21:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
7QHfC015azrK7p99G5Kp7K1fQ60IqQYcs12bM5LjEcV765bJf617qJ4015Nr	2020-01-12 09:56:32+05:30	2020-01-12 11:23:49+05:30	2020-01-12 12:56:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
y06785WzTt7PU4t5T8eEk47358916B8rW70f30DLX7P458g7z5r7i9E8z08P	2020-01-12 11:26:07+05:30	2020-01-12 12:15:54+05:30	2020-01-12 14:26:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
vi3dx5547PeidBbMJPldg1c15eM4H54b2i5328Z585WVIee1feMaan121q4D	2020-01-12 18:54:05+05:30	2020-01-12 21:09:17+05:30	2020-01-12 21:54:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
K23qG66Q732Ef19E6INs9B60zb6KKt7Xm7mfs6K8c0k15gg94s0mmeV4BDQ7	2020-01-12 21:15:42+05:30	2020-01-12 21:49:04+05:30	2020-01-13 00:15:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
dv3b18LiNB64dHZ0BiZIIGX81e86lce61mm1l5lo3LbK751IZ9JN158eNKZG	2020-01-13 12:01:09+05:30	2020-01-13 12:27:20+05:30	2020-01-13 15:01:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
q874dxc511T6rTdwCp30Py66ZRce87t8LLLSVPLt0mLc589q8d7L354dM9py	2020-01-13 12:28:04+05:30	2020-01-13 12:40:13+05:30	2020-01-13 15:28:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
7h99PL9Unec81zDy18D9W9JyK5zK4y0c4KD4Ljz2Fy4Bq66P871e7nZj1oaJ	2020-01-13 12:41:34+05:30	2020-01-13 12:42:28+05:30	2020-01-13 15:41:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
8Je00tp90YJ11x13bu2tMMC8F311YR12JUSXcJ3CK0JSKW1SY2005S36070c	2020-01-13 12:43:21+05:30	2020-01-13 13:24:40+05:30	2020-01-13 15:43:21+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
b1Kt9p29OcCOrAm5p4Xch27wXp43lb3mY69Lb2crd99U14X92RRO13RVg4g3	2020-01-13 13:24:52+05:30	2020-01-13 13:26:01+05:30	2020-01-13 16:24:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
71218o4c5fodtOdzd5uw9sRuZ8wTwp8oLIZ20X515pt5I2g2Z2fd9YzznOt2	2020-01-13 13:26:22+05:30	2020-01-13 13:26:55+05:30	2020-01-13 16:26:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
g1O201Y84019Wd8yT0DI82521pn1094mlNhdC2qVYgDDN7Oi2r2YhmDcgqw8	2020-01-13 13:27:08+05:30	2020-01-13 13:38:31+05:30	2020-01-13 16:27:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
Rdoge48JgW2945A7o2U7N89dp7N458cRs71pfWLIgJno21LdCZo5LG9q5751	2020-01-13 13:38:39+05:30	2020-01-13 14:19:32+05:30	2020-01-13 16:38:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
s5rPZ1swe1E52O4O2I1sOick2C7fc3zBbm43i56mkkuPhf2Dc917jI39excP	2020-01-13 12:41:14+05:30	2020-01-13 15:41:06+05:30	2020-01-13 15:41:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
afrpIg90b15v448gG5T2N85VVa6d70Za51YX9W033fdf5Yh928vdt15R5QdQ	2020-01-14 11:37:34+05:30	\N	2020-01-14 14:37:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
sg3dOup91pDpACDn3KE1lFlV3Z8sda0135D3uZ75O2f0ph87727iAf9bgf9f	2020-01-14 11:38:26+05:30	2020-01-14 11:38:59+05:30	2020-01-14 14:38:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	1d6ce7ba-7161-487f-b566-7202e9222174
089c40fn5m82m5c57lDlN7671t92m1GX4Mb1elq70Dq5X7GuUs59N567s216	2020-01-14 11:39:29+05:30	2020-01-14 11:40:39+05:30	2020-01-14 14:39:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
j5PCA26IjkuT1CC4kpK3J52EOP7um0Afb6ie8EJCe5V2HeO0V10i11eOpPu1	2020-01-14 11:40:50+05:30	2020-01-14 11:45:16+05:30	2020-01-14 14:40:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	900985bb-b940-4c59-b11f-75413b3414d5
ySyNyy7T1e4xHu5k552NM1e4zE5711aRi4RhlBijdpSF94odV1g8987krRhg	2020-01-14 11:47:24+05:30	\N	2020-01-14 14:47:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
54x8FSE1t66KS1qt2vVct9Hm65r5sb5V5q14Eo4YF7mAAsq968U4q8paxF6T	2020-01-14 15:33:56+05:30	\N	2020-01-14 18:33:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
ZSaPeR9768d937xm1Xs96T3o85sLL7NxP8jLox8x9x81Pmjm13reaNk906Mo	2020-01-14 15:46:10+05:30	\N	2020-01-14 18:46:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
K54ay66BBB0a79dNdTRc7L067zyR998dNA9e5bk5597f25ylT9QT7yRx194h	2020-01-14 15:58:25+05:30	\N	2020-01-14 18:58:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
OoBCQ1dgv17c295VR1hn23C925HaNqUPB324558y1VOX7P02aBQ98cacsOUc	2020-01-14 16:10:56+05:30	2020-01-14 16:48:57+05:30	2020-01-14 19:10:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
D91sxTRq5NB2o9b8okd7FBo5bQ0b29nF89s1oaMTQ55wI9Tos2g5FXo52v44	2020-01-14 16:49:14+05:30	\N	2020-01-14 19:49:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
9u2U4kQ0IR6ZR2Slirn0t11429vn18CI20gUvri4gs1y40187DOs40ei9ir1	2020-01-14 16:50:34+05:30	2020-01-14 18:17:26+05:30	2020-01-14 19:50:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
f35l06qHXURd5pr5g0LOzXKbi3ORKSTedS885gG3Tk8p8K2vgjefkRpO08B9	2020-01-14 18:17:43+05:30	\N	2020-01-14 21:17:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
ZW4tuFLd5d3PkWW6P1P6dV934Xe9ZZ44ffdF4973g944TkX30RZ9ee7ROWd1	2020-01-14 18:46:29+05:30	\N	2020-01-14 21:46:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
3hDte5xdhh6dT0775DxbKRvlxa9Ro9hevRvq9qwIR91dp9x1Qe5aoADlDe67	2020-01-14 19:51:11+05:30	\N	2020-01-14 22:51:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
5J9fCv215qnyl2WeAqelc0fOd19f113L7V7E2dol5cH1cyeJ12qq8yc05fZf	2020-01-14 19:53:51+05:30	\N	2020-01-14 22:53:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
y1b5918Yy54AdsQcFUBI2vUJ88eiyWuYvfZffZJfyH7k1kKO5fN5Bis4dB59	2020-01-14 19:55:44+05:30	\N	2020-01-14 22:55:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
Dl0D3TdbuAdOd712dc4dfef527O77cwwbP1eAbdOOv271Rh9v58ciuuqTCC0	2020-01-14 19:59:01+05:30	\N	2020-01-14 22:59:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
l5cZc0eIkW7dobDIRe19lYccWoMIh44koe1Md040Cp1W4SvMU2d0dcPZIa4l	2020-01-14 20:00:44+05:30	2020-01-14 20:07:06+05:30	2020-01-14 23:00:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
m6OVYS1v216366xJjt9O2b6G7aP8gg4wFGV95e2QG67eCMgeu1391129qq02	2020-01-14 20:07:19+05:30	\N	2020-01-14 23:07:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
9g85Pw0qrGb48gEcdCn6n054d5uubiQ6QA9Guj4q1aj10Ci2agcQ42nzEOuH	2020-01-14 20:08:36+05:30	\N	2020-01-14 23:08:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
7PwVDUPbG17z511gYY4771wYRP4D1A6E2z5YDG7t6976gE2PE1eyTI05u5c5	2020-01-14 20:09:19+05:30	\N	2020-01-14 23:09:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
pti5xfJ37DWBugd9V5etq0gFx0dW9C0Gul1gioHt7tR38pj5qm14D51eim59	2020-01-14 20:28:01+05:30	2020-01-14 20:29:13+05:30	2020-01-14 23:28:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
83zMwDgYTyAxdf0f5xYgo13r1f6jz02xU5BhjewbXd7TOfA3oZg0gzfoYC27	2020-01-14 20:29:27+05:30	\N	2020-01-14 23:29:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	384218d0-546a-4561-8c92-6a9738f0f796
0O9S21dr91aGO0voQ5d6PKAXeUFQwhK331eeU11D5sfaeX98x8iUXP1dHii8	2020-01-14 20:32:16+05:30	\N	2020-01-14 23:32:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
oKyPYc2R6l0wSy434d1yU3yyeKI5UQ1dR941DQ0KewKRscer6Q5OI6odrc6o	2020-01-14 20:32:41+05:30	\N	2020-01-14 23:32:41+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	384218d0-546a-4561-8c92-6a9738f0f796
e51aij0NVTSVp1a1fadBeu18UvJ4L6Jnv5W6t16CTgLB50Dc1nS5nJ8VNe8a	2020-01-14 20:33:22+05:30	\N	2020-01-14 23:33:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
5sH9krieSSu4CYsvM3V55cql5I1lddIiNar813l8b18diVC6QO59K9Nsb9eC	2020-01-14 21:18:38+05:30	\N	2020-01-15 00:18:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
3d0410P1T1c5Z099P5eGasa553Ak9yG0c4j09566231eZdc57Ik1KzT1DI01	2020-01-14 21:19:30+05:30	\N	2020-01-15 00:19:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
4e5458084F72f7A8c447e28oNZo4l7XU58kN0S8NZJS47Nf4m282HfF4881p	2020-01-14 21:21:22+05:30	\N	2020-01-15 00:21:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
M6E5qcD6c9Zods5l5697Fn09Dld0Azzc821q8rzD7Q1z17zaEsRfn10F6G18	2020-01-14 21:21:56+05:30	\N	2020-01-15 00:21:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	e40a7414-8020-4472-8669-767db5f90979
5JW2g9J27iN5X4q15YY3o4yE352d002QqdEiEq425Em0rE2EElI4XA0593eK	2020-01-14 21:22:52+05:30	\N	2020-01-15 00:22:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
Mg742yw69TM4eVqC9QC5hzjHj61ugovfo20717v1e9qlvW6gu2El41M4qoKD	2020-01-14 21:24:24+05:30	\N	2020-01-15 00:24:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
1C0v57B18PIePjC0w41ggtY42T5264CY2e30BR17ybh000Rl566l5v1f6aPt	2020-01-14 21:27:36+05:30	\N	2020-01-15 00:27:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
cAZ5ih50wD03ARcD1ei8A0zQ6Rm041w664777565zQ7D5Hx1RH19ATiI5aRX	2020-01-14 21:29:29+05:30	\N	2020-01-15 00:29:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
7iRwZbw7L12xRcanR50M1Q9KgN1xLwUB5DQ9e8155gI7n4I1d1Bcq8a12xF7	2020-01-14 21:30:59+05:30	2020-01-14 21:31:42+05:30	2020-01-15 00:30:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
f29p7EuI5fsCh9u482f2xb677ktq9322LS0Q1T99X70GUUe542Z923J8970R	2020-01-14 21:32:15+05:30	2020-01-14 21:32:27+05:30	2020-01-15 00:32:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
O98Mfw167Oogx431wo97zx7q7d31fl79Vteij741M4erSS9e3q9tS1V1t9J7	2020-01-14 21:32:39+05:30	2020-01-14 21:33:07+05:30	2020-01-15 00:32:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
vPh1hsnM813j01Avd5HEmC3bw7357SuS7cFRt27cHQ66h61An338d3cL60C7	2020-01-14 21:33:20+05:30	2020-01-14 21:34:13+05:30	2020-01-15 00:33:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	1d6ce7ba-7161-487f-b566-7202e9222174
gc7z58T85qVmJXtKeNl1K1l5R77Uc995ci5d8n38U7k29oyK04V6gbT2dqF0	2020-01-14 21:34:37+05:30	2020-01-14 21:35:35+05:30	2020-01-15 00:34:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
7Xk1lwsiHi637317Jkw1FM617Ss0V285e71k0219F12b6W61n0CB6K0kXlEc	2020-01-14 21:35:50+05:30	2020-01-14 21:36:30+05:30	2020-01-15 00:35:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
Wb71eKib100bVR1N5r1I3TBG38NEBx8W13K98f7B55S757S18K91N55I0yn2	2020-01-14 21:36:42+05:30	\N	2020-01-15 00:36:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
uv6733nv7ak55SfFS8fA2SjwU111y8ac5ZPL07a3e9p28pyrjj47A4ak7kfd	2020-01-14 21:39:39+05:30	\N	2020-01-15 00:39:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
A1xK35Z799028J945e5VR9KJTkd969pTU0ppI10d08BSu5e5M5059u413kB3	2020-01-14 21:45:44+05:30	\N	2020-01-15 00:45:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
CE5698Rr7155z11ho5rXoPWRCo152H56LLCFGzPz9Q2z8MCP62w59HPwC5V5	2020-01-15 11:28:46+05:30	\N	2020-01-15 14:28:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
xH2IGcNx4r3q4XcYd28ehNbdI2BK4aHcSr8BbcnQ8bMje528c1bx7Gx65x2c	2020-01-15 11:31:33+05:30	\N	2020-01-15 14:31:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
byLGLC4CZ8S8h643zpSJe66k5fD0kCy0CSKsMkkzNZYz146C1Ek5Cf4g5MSK	2020-01-15 11:34:00+05:30	\N	2020-01-15 14:34:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
a44s7f898zs4ZUscKsf71B97SK7Jxa70TTbbO4dU510hT47e7K0FUe7xe7y5	2020-01-15 11:36:13+05:30	\N	2020-01-15 14:36:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
l680GbSgU27SV8gh1V2HGnlc188hGhFSdH2b1eJ7fUV7H809cGaVG3V18f9A	2020-01-15 11:38:48+05:30	\N	2020-01-15 14:38:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
jrt7aVwRj0b1282enmm81hG1ipyGV0h8y086T73Jc8RtCvDim718pm8aCJe8	2020-01-15 11:41:38+05:30	\N	2020-01-15 14:41:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
xuZK370xlpA1563theolATeNmeTh2i5Vh0tyA186Ke73w95e5Z0RinK51il1	2020-01-15 11:52:06+05:30	\N	2020-01-15 14:52:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
Jowhd4dUCJ4487s5wb4Uuwn67Jw4kjhe3qJ409RJ0e87khMo0Mk0ob807hhc	2020-01-15 12:08:04+05:30	\N	2020-01-15 15:08:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
Rx1f2R6Dh6RbxbZ7SSxeS79H225R61QR222dhO1O1926sVaA2hRSRSg21BfD	2020-01-15 12:23:36+05:30	\N	2020-01-15 15:23:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
dU5EkC6u0N5J5d51B4T2I6ij1dF981pwAbBu867jpC100C9dJt0iNm5b40P1	2020-01-15 12:45:50+05:30	\N	2020-01-15 15:45:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
2n9QFMM74v9UwY5l4d6b3b1Yt4huv41c6eOff5bWfPkf770Z5bvhpc6pbbO6	2020-01-15 12:46:47+05:30	\N	2020-01-15 15:46:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
4s7Q77sw8r7m6bI09a15oFKL7M7AMUM5120sJ0PQmAM68d7KsG0v2P0s71Uw	2020-01-15 12:48:00+05:30	\N	2020-01-15 15:48:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
Ko4mNu9j6xvcde9E3KEQm3HvucUwDN9Qe8FDeu89X8FvN5e4w1sY3e49NPV1	2020-01-15 12:50:20+05:30	\N	2020-01-15 15:50:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
ak4eoko7eb4f5p6h3JiKrJzayBe0a47f79rty7Y19koboTo9bOJ7rroxb0J9	2020-01-15 13:01:10+05:30	\N	2020-01-15 16:01:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
0C4T7oXs2Z555XTE8C21e2504L29t2AXfPXDXs979kkfI7s46T55eZsm0I5B	2020-01-15 13:33:22+05:30	\N	2020-01-15 16:33:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	384218d0-546a-4561-8c92-6a9738f0f796
t4V0KSEwz7z0K0EcXaw6h629Ek6ZdXaEW68XK122TEH90fYzY0zaEe0zfJ1H	2020-01-15 13:47:04+05:30	\N	2020-01-15 16:47:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
g9GD8mTd7XU8H52667zH9a8g8835NHSSXHY62VXJ3geOu6UPHH974I75V7Ej	2020-01-15 13:55:46+05:30	\N	2020-01-15 16:55:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
cKNnNmZW3Y8895A5mEn914asnen7ea45nf6JmHneQ5r4eg7619n6c194sHnq	2020-01-15 14:08:00+05:30	\N	2020-01-15 17:08:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
0IueOy9Jgd97MIA919e4PS57o95O5F3eelU741O4d87Cg5J44nhDj0pbm8d9	2020-01-15 14:08:44+05:30	\N	2020-01-15 17:08:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
Q2qgArbcbtDA8Fv67f7x06BcDd4x2wdg9vF7b9bL6D47c2gmrcsNDcCyCbLb	2020-01-15 14:10:32+05:30	\N	2020-01-15 17:10:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
ZtM500fz5rs5055bp405Xrw7f7M0vT5z652O1k7wX94X077zxZ55p544a9Te	2020-01-15 14:11:04+05:30	\N	2020-01-15 17:11:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
l0VkRpUf9377bdf69V3U537a2830677a1415na7GUPW7767dGNE5n2120Ja2	2020-01-15 14:12:14+05:30	2020-01-15 15:45:42+05:30	2020-01-15 17:12:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
pC3HK96gt1uH3Qutk939y6e13c3yFeeK311ea5HGZfe3Ck3101uOQpCeT7c8	2020-01-15 15:46:23+05:30	2020-01-15 15:53:44+05:30	2020-01-15 18:46:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
8hag0I0e35IArArJb8YUM40M27ebRJoFGdGIeI90QVRV6rQe5ALnvU71aV5a	2020-01-15 16:10:02+05:30	2020-01-15 16:20:17+05:30	2020-01-15 19:10:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
58JcE39kILT5KO09616JT83z95WUBJ2091HDMw0ETPcI3k3205kI8qpE9Qd5	2020-01-15 16:28:56+05:30	2020-01-15 16:36:05+05:30	2020-01-15 19:28:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
96v0OH01PtIOv8C5vzVKLY12zQ1Ht3eO8zspLOa50V05d12LqeOdq8FK3NQ2	2020-01-15 16:36:26+05:30	2020-01-15 16:46:52+05:30	2020-01-15 19:36:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
fvG641cK1S42fJ5Ef5t4H13tP1bQe94Epc5eJ4F1C0v19O8D5cN4c1N6treS	2020-01-15 16:47:32+05:30	\N	2020-01-15 19:47:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
e2281b1x0scR6k7nV8U67yoeUW85Dnc92tFA7D0cdMt5A7158lUMpDNe2VmU	2020-01-15 16:48:00+05:30	2020-01-15 16:48:06+05:30	2020-01-15 19:48:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
0YfcYfE4914037YwS0e7c78B88bEO277rwvV78z3fre7eUrFY5vs37v1Bf3p	2020-01-15 16:48:23+05:30	2020-01-15 16:51:24+05:30	2020-01-15 19:48:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	dc6e8456-7fc5-472d-adde-28939b3da901
X5Qg29f9ee7e9y69fm2b5NCAANHnfBXyf2ef6y8y9wylb25B6ffr35JemC88	2020-01-15 16:51:33+05:30	2020-01-15 16:58:35+05:30	2020-01-15 19:51:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
h75o5Wm322XQ276c59c7IJUD11pUiM1KiX63S719IaaclUQ2a3wD711WO80b	2020-01-15 16:58:49+05:30	2020-01-15 17:01:19+05:30	2020-01-15 19:58:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
7APxByks26L38syfaDe8qseT95PeulKfT1rZoQ6572u3Dlf0ld6o4Z8451jn	2020-01-15 17:01:31+05:30	2020-01-15 17:02:29+05:30	2020-01-15 20:01:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
bd20E1IPd9I5658U2M0eeSL0b9l74lfYlU5cFM58c6dyM6r4478Sl4rUadMV	2020-01-15 17:02:50+05:30	2020-01-15 17:05:43+05:30	2020-01-15 20:02:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
6Vx12KY4IeatNe17Xe6e83Oe4xVw4Hoek2u3ESkHa24194Lr9e5e1k1Xgvo9	2020-01-15 17:05:54+05:30	2020-01-15 17:07:32+05:30	2020-01-15 20:05:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
25g9n4r0MU8A7C5OU2d1M2929X9P8uGz11287XxMsyXt9Bh8ANxnXSwMuGC8	2020-01-15 17:07:41+05:30	2020-01-15 17:07:50+05:30	2020-01-15 20:07:41+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
5zee4CFzAnFl99i72GrllwJSG8ls53E7VC7pGnGVh16w6aGCoe1NPC05wxfa	2020-01-15 17:08:07+05:30	2020-01-15 17:08:49+05:30	2020-01-15 20:08:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
BE628qyB81h73p4Ik7p13680b1M454Y588lOW19j1lhelv5l2f0z48GTHvjl	2020-01-15 17:09:07+05:30	2020-01-15 17:09:21+05:30	2020-01-15 20:09:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
BXZe3GzLfNv3hE6ee19XXyIQr5LE9Qzr318oeLpe513RrhQ5Vh5f8vkXb1bG	2020-01-15 17:09:33+05:30	2020-01-15 17:09:58+05:30	2020-01-15 20:09:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
dC8D8112514o8pf68fJaCfahQJg5xSR23TTJkThJchb8faR442Rh1a1b963c	2020-01-15 17:10:12+05:30	2020-01-15 17:10:37+05:30	2020-01-15 20:10:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
BQnxn4BcUcaIZnf10E4T60mb541en358xys70obnfT485l1c1U91xf5x2xc5	2020-01-15 17:10:50+05:30	2020-01-15 17:12:59+05:30	2020-01-15 20:10:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
1gY7xf7ruY57uMJkawe0p9xg704f9OM9D4w4fmxfX0B42m448eR9488uK9p2	2020-01-15 17:13:10+05:30	\N	2020-01-15 20:13:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
f47ih0eivew8w7w8s698K9e72W9urZsxcrVJr299hL5AxUWv888xv5xL5KJ5	2020-01-15 17:13:46+05:30	2020-01-15 17:24:33+05:30	2020-01-15 20:13:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
727z731a6l8aW7X5FP99A5i3l1w2f7F9lyH377j5z55766Ki05522Lye7803	2020-01-15 19:15:07+05:30	2020-01-15 19:16:08+05:30	2020-01-15 22:15:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
17t49iR2i0WK185uM303tt48x5na9t028uWu1Zkid54116LuNT49JDJ98jd9	2020-01-15 19:16:22+05:30	2020-01-15 19:19:42+05:30	2020-01-15 22:16:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
KAJ18eh15d57N1l9PfyNxtP1o18mYx1eaF4LhHXFa1N9o34fmx21881QLk9H	2020-01-15 19:19:58+05:30	2020-01-15 19:42:49+05:30	2020-01-15 22:19:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
P0MKWH99ExA3PV5Uu70k83iH7hH1H13do8dbhLeRhwxukR1o71HT5nw3WedA	2020-01-15 19:43:07+05:30	2020-01-15 19:44:22+05:30	2020-01-15 22:43:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
47Y4n7f92U5qfa4s221vYyh1ggyz74v4K4fry122e7D274Ub7en16TY647Xg	2020-01-15 19:44:31+05:30	2020-01-15 19:49:35+05:30	2020-01-15 22:44:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
3KX1F79198dn8B1V1Fo4wawP57dXQmCY24j9MfmxmJRK51whY0C5p11CBp4f	2020-01-15 19:49:44+05:30	2020-01-15 21:54:25+05:30	2020-01-15 22:49:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
ve1sN1W315rGeR19gn1fR4rFFee91RF59e6C6fU61nFAU9ym11Te43BeAC1R	2020-01-16 07:10:06+05:30	\N	2020-01-16 10:10:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
lMc33dday3wx1K3kbvk1bkA4u2YkxExd9e3166GKcc9O03dKA9VM2eqrG4FG	2020-01-16 07:11:32+05:30	2020-01-16 07:33:13+05:30	2020-01-16 10:11:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
7227eqj202098922a10X2f22p5415t51W9Xz2iihe12r6P21g6fGTzw9u20x	2020-01-16 07:34:12+05:30	2020-01-16 07:50:24+05:30	2020-01-16 10:34:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	514d2016-34ff-4a20-8277-d61af58a171a
2E5d5cE9Vlf7aE15U8X7cKEtfl0pcbfKhX1OHcbl1zDd167u0cOXE91H5jcf	2020-01-16 07:55:52+05:30	2020-01-16 07:59:40+05:30	2020-01-16 10:55:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
119o21Tbh0q4rJX9F8C0101wqrx0CY9aOt1IFBKJfjYcs24K710f5j1Ku0CO	2020-01-16 08:00:08+05:30	2020-01-16 08:16:57+05:30	2020-01-16 11:00:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
4D181k4L6VzVe31Q0re018E98re1760oEVMlK9z75QIV9882z1f8foV12V19	2020-01-16 08:17:13+05:30	2020-01-16 08:22:22+05:30	2020-01-16 11:17:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
0mn4Xt3T417X0Ws55dO9e4m5DcXcw9s3THtF7FXs4wOKe511G5Gm3gKZs07G	2020-01-16 08:22:51+05:30	2020-01-16 08:31:37+05:30	2020-01-16 11:22:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e0574765-71c6-4a9b-ad0a-1d9ab8772148
9Xze9dX5d2ZeJsb1044bUdTsdddy0Y9DlDbE44mbdf422D2flE5dyEi95e1E	2020-01-16 08:32:05+05:30	2020-01-16 08:34:31+05:30	2020-01-16 11:32:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
D8rf4U13BP3rV67G27N83VxB29Vn74JM8d6H51AUxRD53eY591Ne3dAvN8Rz	2020-01-16 08:35:35+05:30	2020-01-16 08:45:26+05:30	2020-01-16 11:35:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
iON179ddYGKd5j4iGajee0Epp107yu5c0e13K16Y5j755S554Q5L16j84B2p	2020-01-16 08:45:55+05:30	2020-01-16 08:49:37+05:30	2020-01-16 11:45:55+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
8440qOzx7gdQlHQ11qj048Yxq566Fg5r50tWx17s48W0l714O65IQQl6t3t6	2020-01-16 08:50:16+05:30	2020-01-16 08:52:41+05:30	2020-01-16 11:50:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
j88xD32P3eXy68136j6d7Oa57qa598a1p3578cfWcafV1a4c15fd4o0q6f7t	2020-01-16 08:52:53+05:30	\N	2020-01-16 11:52:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	384218d0-546a-4561-8c92-6a9738f0f796
1h15c7nRXo8t1gT5XhX7kc9CmnhPu4RRN4cLumSO1kCSS454tV7d1LLD7d9X	2020-01-16 10:49:04+05:30	2020-01-16 10:49:21+05:30	2020-01-16 13:49:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
LSD1FRFB2S5Ln9t15GW62tB2fwo459wQ15f69pff7dntU4BKP67a5d1ofQ25	2020-01-16 10:49:53+05:30	2020-01-16 10:51:55+05:30	2020-01-16 13:49:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
VpXCd0680B54jj1eHgf9123cY81l1jG04f1JX4z4z7z85cyzpRRKvfZ91060	2020-01-16 10:52:39+05:30	2020-01-16 10:55:29+05:30	2020-01-16 13:52:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	003c8504-caad-4e36-a34e-a1cc54f9e4ce
6883m1p3f74Ro107Y8dccCx5V314i9u556x378HB1WvgVYf128186zj5R8u1	2020-01-16 10:55:48+05:30	2020-01-16 11:16:46+05:30	2020-01-16 13:55:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
o5451uNUv5D1fdG72EIJZ7671Bt5u619Yv2f253Sv1tuUtDZJ2IVej1je2u2	2020-01-16 10:50:14+05:30	2020-01-16 11:29:00+05:30	2020-01-16 13:50:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
KW57AcnuSfQQnk33HAHA8Cf7LQk431nq6tLnBHsFq8iHf0KPbWPdfdq5Pexx	2020-01-16 11:17:25+05:30	2020-01-16 11:32:45+05:30	2020-01-16 14:17:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
9EB2s2hKc1Adeks1PKPNU0f686eL1B111mA95y6x1251yD7Du65oxcU0YBr1	2020-01-16 11:33:00+05:30	2020-01-16 12:03:11+05:30	2020-01-16 14:33:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	dc6e8456-7fc5-472d-adde-28939b3da901
1ZFaskTBuaqOFubF8TmMOpkMeA7k9041AFsMs33Lbk8T8yBkj0a7iuRvjm35	2020-01-16 13:08:42+05:30	2020-01-16 13:57:10+05:30	2020-01-16 16:08:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
WWjQbja0O4525u63IXeao6O6Ic7d8gj83jvg0aWooa8677T55dXa850fHF4T	2020-01-16 13:40:52+05:30	2020-01-16 15:27:18+05:30	2020-01-16 16:40:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
ZfNjfNPka9br9dfd51hfba7sF27L7oAKJ559KmV159Jk95Rmb9R9kWm91111	2020-01-16 18:35:07+05:30	2020-01-16 18:53:23+05:30	2020-01-16 21:35:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
906Gee36DMFVU69GpKUGJe8e6bmHexJA6tcjrmRbc13PU403ee57345de216	2020-01-17 13:28:51+05:30	2020-01-17 13:56:43+05:30	2020-01-17 16:28:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
eNk5zX01OgvP911n45N422ztk061efOwL129Oy1zk6yVg7ze5CkEC02p6yv3	2020-01-24 15:32:39+05:30	\N	2020-01-24 18:32:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
p9bJQr39l5au87hJS1JY8j8zl5RLc7aL7fmtp79Fb9a2mm1olaZdD1C45D2n	2020-01-24 19:38:34+05:30	\N	2020-01-24 22:38:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
bDb65D338U5341bBUtkb9P9Yv8l5D1SbSJT8Ebhl9423v8vhq094e5Dtt119	2020-01-27 12:30:19+05:30	\N	2020-01-27 15:30:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
a42220Ia3zqe38qbz6e3vGb2Uu50Xeq2UWG32x322FNfUFTvxe31B08lf9a8	2020-01-27 13:17:55+05:30	\N	2020-01-27 16:17:55+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
WhT895er09129e85FH96b1hkAO5a1N1a15ziR111bN1uhOnN45NH8245AeA1	2020-01-27 13:29:15+05:30	\N	2020-01-27 16:29:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
7lQe41VeiXrT1vOC0b2bVb9fMzSfSb2J20qqmS90vO37dIq29bA532fG8Qdr	2020-01-27 16:31:19+05:30	\N	2020-01-27 19:31:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
b7K7n1n9If5CT3121b3CQQ9VQbrI921Sr91TbBeM1b9n10J9z4N5VcPC6xi7	2020-01-27 21:16:06+05:30	\N	2020-01-28 00:16:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
YeAS5nA03fYSE6EIUFfmfFIfXSA58nxEwWS5EWQX3S0Jh4n0954AXjLsIUn2	2020-01-27 21:54:23+05:30	\N	2020-01-28 00:54:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
XDDe28Ml1vJ861e01sJ8bHY4h6eWX7v1UW5J2Dd6MbW0JHXPe44VV91eDVu9	2020-01-27 22:47:20+05:30	\N	2020-01-28 01:47:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
vXaaLiar5s02KO143daJhm88a8E6crm5pOiG1a6Ko885cVVt9LX13X285Z55	2020-01-27 22:53:38+05:30	\N	2020-01-28 01:53:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
0O2f1V64Q5cVffDKkVX916xXk8h10RXHG5946fofk438fXd5caR6hcHX91nP	2020-01-28 11:34:36+05:30	\N	2020-01-28 14:34:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
54bM95et56aJ1f5DV588266Yd10D2888Vp1V85LZ0iY451Z2W1yiW1oG8bL0	2020-01-28 11:58:05+05:30	\N	2020-01-28 14:58:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
qzd0eeTp0n13u9MTx05j2kc1b0z14eUz5He1N0W15pjxEK2D6l91N6Od6E1u	2020-01-28 12:48:21+05:30	\N	2020-01-28 15:48:21+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
ql943nH2hOvH5YZ1Iq1OI520y2v512hl1L6f8h5rxc9qlYss0xTD454BN5LH	2020-01-28 15:22:32+05:30	\N	2020-01-28 18:22:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
opST9xNuOup9T2A6A97k1uh050TP04kh1cBd4qJdpET6r5d4hhr46x9EJOFS	2020-01-29 12:01:56+05:30	\N	2020-01-29 15:01:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
a925v8t9FHF87080L1kdd7cwq3AAFaw234335788397Ns5qd37c82K92902Z	2020-01-29 12:08:54+05:30	\N	2020-01-29 15:08:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
9O04zjQ8336fVL52O22fpdd4l8F676Ulfp4jji8d5WP3Gf300B8Xe2YX9OkV	2020-01-30 14:43:13+05:30	\N	2020-01-30 17:43:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
29m168jiiZ01S35PDCa3lIJ8992ZH3HpPJ3j6p1mr7m390Z672F5jsDFP5S9	2020-01-30 16:08:27+05:30	\N	2020-01-30 19:08:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
0n82c2L2CM4vtY46gQp70f2uT40ordcG7Cw327vZU58E31Tl8b10rZ1e1l1w	2020-01-30 19:09:32+05:30	\N	2020-01-30 22:09:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
v0CR1xh053eoH6r00JOoT3BSn4SJpk14xG59851C72q17l3kG4PY3vHpL0B0	2020-01-31 07:26:07+05:30	\N	2020-01-31 10:26:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
0sQh43enShh03g8nPv756429psVn512ftHthPPXeM9R662H2XT75nV749S83	2020-01-31 08:57:32+05:30	\N	2020-01-31 11:57:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
iCLyu4bo3Xd1GSff68lfd087d4037le4yB195soee7fmX8em7S5doN7QCf3f	2020-01-31 09:00:05+05:30	\N	2020-01-31 12:00:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
rTtb3dtca1Vq0f31V9VXKX14FkdpR39ozk1toX0tHKSbctrfS4gmrqg4315r	2020-01-31 09:03:00+05:30	\N	2020-01-31 12:03:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
62DNW0HuSS63K2dW6Dh9bCvC3qPdPTCWdA1Wnqidle2P09h2AfAW1DiK54nP	2020-01-31 09:06:30+05:30	\N	2020-01-31 12:06:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	dc6e8456-7fc5-472d-adde-28939b3da901
A3Qyf0md0cyg1091db7NN1Om0c90Bac6QAkACyV7YPy1Mk1g5J3OPO40y39q	2020-01-31 11:03:11+05:30	\N	2020-01-31 14:03:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
d5e7Z9Ja68111d3d4Kce0o1e1iqLC35514Cd9137dlqCIG5M399eHW5v3rGq	2020-01-31 11:07:56+05:30	\N	2020-01-31 14:07:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
w5p9bwlewBQ1c86Ijg603Q16B8KMcp77N7Qy53dd8B767wwaN4b88dsW39G1	2020-01-31 11:08:47+05:30	\N	2020-01-31 14:08:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
x49e89bjNANL57Nj319DXF0GLQ1t1bT99bWdcID13184s4K1D71223fXWbTK	2020-01-31 11:11:31+05:30	\N	2020-01-31 14:11:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
l41NpB8Tac4Y6U5N2gh4D23mxLM115ec31h648xaGqDab81p15N97j227aI0	2020-01-31 11:13:38+05:30	\N	2020-01-31 14:13:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
zVp05aj6ap00Eau0U2zza5eT030JvcXOate1Tjbdca1W007t3aW9J04adY3a	2020-01-31 11:17:11+05:30	\N	2020-01-31 14:17:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
lOH49fbH7f03ik9UZ15Ys7fyUHn3J559h5f4D9U7d3I9M99Tw3nF7ghjO76T	2020-01-31 11:18:13+05:30	\N	2020-01-31 14:18:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e40a7414-8020-4472-8669-767db5f90979
2K71EIR1zeE5Ec7175022IbV0ui39hpey5DE5A1943I03R34AQzzyJ07B09W	2020-01-31 11:19:57+05:30	\N	2020-01-31 14:19:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Vq8sx0xc0V088z5Q2c30x1eOp0a898Z9Z1sBU3c2a9IWc1338SQJI424p3u1	2020-01-31 11:27:23+05:30	\N	2020-01-31 14:27:23+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
8158IbrGI1SiPA57O295rzpecG3rOi335OIV76zexI5Z2W05Z3iUGiUO5VH7	2020-01-31 12:08:13+05:30	\N	2020-01-31 15:08:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
aB3aD4141eKQXbfN87774ax5MZeKK2NQ5f2lejB51cs8NvencE0K9KWwVbsX	2020-01-31 12:10:39+05:30	\N	2020-01-31 15:10:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
2EUA2lI32Ld4ydGY11532I7J06n7e1k21Ab7hg2GU8B8i0ovG3IitvG3OkfZ	2020-01-31 12:36:59+05:30	\N	2020-01-31 15:36:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
NbP8GPFN7kS4u4tOFQeR31L403e4jq2C7Uedl5112dO2du95A01GH4xCYuYO	2020-01-31 12:37:10+05:30	\N	2020-01-31 15:37:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
49lGzVGidF6x55Ny96vcGNUI1594blbzj0Fe5h7xixBe1yo5coNli9sIoc5i	2020-01-31 13:19:19+05:30	\N	2020-01-31 16:19:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
0e28l082ea5Ns8P40K08M4N0NNg1Pq8y98aJ03TNX01J0sa158y5sI195KQy	2020-02-01 11:00:19+05:30	\N	2020-02-01 14:00:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
nh21fZ916OK9p3SJJ0kpnH6c6JEN5IpP633GP3kfE28fjGY51lKYek56P086	2020-02-01 11:28:01+05:30	\N	2020-02-01 14:28:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
195655Hos2FzVeeN955HV16I5F1e3z2Ds375ezps7zlN2NAA5YA5pFzs06Hl	2020-02-01 13:38:51+05:30	\N	2020-02-01 16:38:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	\N
q2M2695H2nxbiTt92H4J68H12828W0dbKWx5xhKwJ25H4F8JZDIqN49s6H6K	2020-02-01 13:40:28+05:30	\N	2020-02-01 16:40:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
bOWl9aH8b4rbh0HyK5135nl5D608hV19EAuvh5n5HawZWoKo5fKP6gV0c796	2020-02-01 13:41:17+05:30	\N	2020-02-01 16:41:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	\N
51FOU55eiiC5f56SuBq6beS90uCz2b2R3cr5i3aGqk58B3eakEA15YqeeH4e	2020-02-01 13:41:31+05:30	\N	2020-02-01 16:41:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	\N
OjPRv17PcW1E3373EeD2RkJPW4W3t3zf7ww5AoUo8AvtEDa8K1L8Rblw9JPe	2020-02-01 13:45:37+05:30	\N	2020-02-01 16:45:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	\N
2L28j70sT7QVq70ej55fY30bOpEML1Q4JJ78zJ85oNAfZ3QQ8eNT52NTIQ72	2020-02-01 13:47:02+05:30	\N	2020-02-01 16:47:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	\N
46aq6aOv0Ey4555qb3zo3iob7qp3f9rb2yQUp7fr7ja7fjf6rd9oy1b594Ov	2020-02-01 13:47:45+05:30	\N	2020-02-01 16:47:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	\N
Q5e111Igie9R5333vVEf59G3h0e36901Q99f71W1aeVH5l59rnf9a1XSvEK1	2020-02-01 13:50:17+05:30	\N	2020-02-01 16:50:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
dZP1L535O3r5lcsrwr01DCLS585chB911wMwsUM3m02v35sM58O85sw138s6	2020-02-01 13:50:51+05:30	\N	2020-02-01 16:50:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
1Wk6MNN144U1E3Hn1hCbqkhHk1UR0sbTNq4Lve6KE58p8NLjR6qw05q8Neb5	2020-02-02 08:50:59+05:30	\N	2020-02-02 11:50:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
3Upcaszdvd3MAI1mBA8UUsaN0EBrdGUPW37486I1M8M6Ic0Y56EM8800PzzW	2020-02-02 11:40:11+05:30	\N	2020-02-02 14:40:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
A88kRRNWa5gOwzpq68xda06p44Umd13RgUk41W00zG5RMk3W6W415az34d46	2020-02-02 20:14:54+05:30	\N	2020-02-02 23:14:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
g3R5PogOLc3MXh2f1A3f311f2Z6X1233c3kNAqX2fZxrA1DmFqc3dma9uAQo	2020-02-03 13:00:00+05:30	\N	2020-02-03 16:00:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
3vWoH9x21032183l4lWOSVeVFb3K35PB7T8H91JkUQ64J47KTtF5BS9W0d8k	2020-02-04 11:42:05+05:30	\N	2020-02-04 14:42:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
IK0fx0aRY2X9pOpgf2xYRW7aRpf30c83og8q7ch0H6pHc22NmRN02ootGRvc	2020-02-04 15:17:22+05:30	\N	2020-02-04 18:17:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
4u994EF8Ivn1Q2323tr8K83447JJcr3Ljz7l3MF8TL62E32a8vEK7z94B5Kl	2020-02-04 19:29:03+05:30	\N	2020-02-04 22:29:03+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
Ofsa089dvdMS61bf9uPf9oJbJ5S598sYYxH40d4a2aovd86rQbH83eEiXx9m	2020-02-04 20:00:08+05:30	\N	2020-02-04 23:00:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
s15509aU58Fxg6aeV8x65n86ttn1rb64H2Oi01to4US3bRirp2b2420bRx2B	2020-02-04 20:00:45+05:30	\N	2020-02-04 23:00:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
q832jvLZZaEB28oR2840jh886EVU2M36V3v3G3827jo605K3dGTa8Z812488	2020-02-05 12:34:53+05:30	\N	2020-02-05 15:34:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
1C9158Atv53aAwEk40Sg3y5mv1bNN69Y9WtW5YgeSS58459O3012gw1S8O2W	2020-02-05 16:53:34+05:30	\N	2020-02-05 19:53:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
f6x4PbvpLnYpndi44bJVbD1D39n8w8vPb80LddEaKx3x5x8Bcp175D8D0619	2020-02-05 20:59:44+05:30	\N	2020-02-05 23:59:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
6jG66S58f3b59cu1L22q5jSb3ABk59YLcI50TT983f3Yc35pCsGe63L2s81v	2020-02-06 11:29:52+05:30	\N	2020-02-06 14:29:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
0c0CLkyD4wBaFy6t7e1e2LN70vq0g52A4w5686Ltx7X4Ztv03065fkR1Jb3S	2020-02-06 11:45:13+05:30	\N	2020-02-06 14:45:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
1bZGg13f0dc15JSW263nX254vhGN1Hkq2ar3R12bx7G562g0d1nH9rl1y4Wb	2020-02-06 11:58:52+05:30	\N	2020-02-06 14:58:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
5UoJ7svcippJUMR37oQe8Mbbahu9hvMFQ7bterunt66teJx7b7Fbv1266MbJ	2020-02-06 12:34:22+05:30	\N	2020-02-06 15:34:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
7eceKf2KSo6K701KmoVL009Z59C3PQ38PE72PzSP9Sf1KabfS3KMmt72o0cj	2020-02-06 13:09:56+05:30	\N	2020-02-06 16:09:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
9e88J09xbm74850915e899M1h8R3F78f2mcUP61O2UcnF3O9J0MI86300mxf	2020-02-06 13:25:08+05:30	\N	2020-02-06 16:25:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
04WEJwCplK8SefCJBhe4981ec7wfg9iHHieDZg835eiZ7T5Bte4W9j7HKb56	2020-02-06 16:34:57+05:30	\N	2020-02-06 19:34:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
2H13t0rbVeSh2wRzd6VI2WwKH151V75L0f25aebu184141huw1feB88329kh	2020-02-06 16:39:06+05:30	\N	2020-02-06 19:39:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
z51F4kqsB51v99l0lc8F8FP19UG8851vk55t1tZzOyTu08e6CzCTH533wqP2	2020-02-06 19:44:12+05:30	\N	2020-02-06 22:44:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
1hB8Nh37ch7d5514lt6rC2CS701102WhWnOgdHW815Ht85nm8Qb0JYO5rH15	2020-02-07 11:23:05+05:30	\N	2020-02-07 14:23:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
344FN005kL8g1vb3OlBIUqnvvu4vHk7XFv8320F51vbOqX755LHOkeeNtvgO	2020-02-07 12:00:29+05:30	\N	2020-02-07 15:00:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
OE11c1ee6O2g4Yta0e1rcZP5RneRnc2M5n91OX1wvoOPwXkVYd4MM4fMdEw6	2020-02-07 15:33:02+05:30	\N	2020-02-07 18:33:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	dc6e8456-7fc5-472d-adde-28939b3da901
V3pu5kMuc5V3aYL3k77yeep94Bas3Za7UzM08c8c08Nd6epak5Yy58m0Vf37	2020-02-07 15:33:18+05:30	\N	2020-02-07 18:33:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
58whdjh93R666HjimjBK8A69sxTm69yL7jz1NYw6M55y80JT6f1QR3mmMHF9	2020-02-07 15:33:51+05:30	\N	2020-02-07 18:33:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
9oDrDzX8sO01391Bo24FyW1989O21s254srJs4s1agXdD640zS29d189vF29	2020-02-07 16:31:22+05:30	\N	2020-02-07 19:31:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
fgQ15nonWFzOGW1Q037n73cJNm8d9fvfQ17vE5D7YY19EGh99Ig34x8ggEgv	2020-02-07 16:31:39+05:30	\N	2020-02-07 19:31:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
92c35j1V3sCt4z1gL92Cj1243w6LV894gtz4Xs56q4v81rfwm6L11Lsn53p1	2020-02-07 16:32:25+05:30	\N	2020-02-07 19:32:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
45T521r731vr3F67CTUj5dJdU8qCchH7dvArva6gRXX57L817MiwCx7OQ15c	2020-02-07 17:53:31+05:30	\N	2020-02-07 20:53:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
6591300uHkTkX98tfe7NWt3Peit96Uix25AZ0GTSkU0jPx13HP3CjgqXOgG4	2020-02-07 17:54:18+05:30	\N	2020-02-07 20:54:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
59IqxYlkNOwdd181f9f7eP1W1B9273PGe8kW1Qp5GP5N9d5e1558e451DPnz	2020-02-07 18:04:00+05:30	\N	2020-02-07 21:04:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
e3ATjkjO15hFUOOcm05dB5jeNdA53OZ71cmhk9p58ee78l3p0p07nvswn1mO	2020-02-07 18:04:50+05:30	\N	2020-02-07 21:04:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
iYQ514d9UCe17d76211O5le5wi2daA7g7sgdl7iU3P0KOB1yy1NzsdBx23cB	2020-02-07 18:17:07+05:30	\N	2020-02-07 21:17:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
P7Lqh3J7874f7LodP79XUIlPz9XQTh27BDO8B815JhDlS3af6hQli1G0c7l1	2020-02-07 18:39:14+05:30	\N	2020-02-07 21:39:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
idfF06E63Iuw0Yq330wqii7k389jlb1AYbEEN0p06yk113dyfcN6lfyE5Y6A	2020-02-07 20:48:13+05:30	\N	2020-02-07 23:48:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
1nSn2f98fHDiynJ9o5ZJfH6Y1fDQzj2620ofg7SzYff1YYsi2qu5v36zf271	2020-02-10 12:28:18+05:30	\N	2020-02-10 15:28:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
Jx34NGoVf7Q3GhpBUQQd90oV5FBe46N8890QlVU9PlGv1PLB55U09R18QCF0	2020-02-10 12:56:16+05:30	\N	2020-02-10 15:56:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
yWqfagYE7DQ1Csgg55JQ93SMJC5r58Q3eSsSR8bMS31025f9hw556df3M5RE	2020-02-10 12:56:55+05:30	\N	2020-02-10 15:56:55+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
r9kkX1a1c5g159ht805e91FCJy0lb5D5GTpFof01aYX0FeMEmeqb9S099aXX	2020-02-10 13:09:40+05:30	\N	2020-02-10 16:09:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
F8Vzhvb1OEG8yvlFqGGFIn14pAnxVj0n0G13NO20X6t32nreg6p424inKeeE	2020-02-10 13:10:20+05:30	\N	2020-02-10 16:10:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
Mmdoz6wr203wdSv7112e6f0Lz5uJP56f8333ap8NuyC6GQ8a8h6uA18642Gf	2020-02-10 13:10:43+05:30	\N	2020-02-10 16:10:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
a5q1sY78R085201t4sueOba0U2Z5s219gAtAV4A4a4MiRh9o6hbW2U29KgQ6	2020-02-10 13:11:30+05:30	\N	2020-02-10 16:11:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
H6HB11BQ113Iq9088g53B0a4b141X2Y65gA157WFgg5b2Xrpu56pYEFus5a7	2020-02-10 13:13:15+05:30	\N	2020-02-10 16:13:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
e2m05164L40Aj6K42g25Dx11f25Q6s6aegs93NfyP6j4DDa6U9jI46S6f6rM	2020-02-10 13:17:46+05:30	\N	2020-02-10 16:17:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
3T1X3ez6c102n6X4B4sCy9145fT6383S6bQh5B2c31CCJi487X0Tf1cZ2aiS	2020-02-11 12:58:22+05:30	\N	2020-02-11 15:58:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
06Lm4u0tQPP117RPJ6d1eXRcCBqPnyRll5ik1PqP15RO1PAaiEwCt2dt1PQ5	2020-02-11 13:08:45+05:30	\N	2020-02-11 16:08:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
7I830i2230le6a11Z6m3368DSS78JlJTD1sO4TVJ8XpdNG161WNV0SI8150J	2020-02-11 16:02:47+05:30	\N	2020-02-11 19:02:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
4551z4e8zeDq5hq8Vt5Yt2eiy62642255lPez2fY254y81P5zqj6ugFthz1P	2020-02-11 18:06:22+05:30	\N	2020-02-11 21:06:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
at1Tf2NC5v7lhW133N1WH5a02w5srM05M0j70r4h951vz2Cl7C80aMt445Xh	2020-02-11 21:50:38+05:30	\N	2020-02-12 00:50:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
R0RrRcNeb0SaBz31O48Z5bBt1248OR40b78T8143G076O7bS3fSGa3s83B7Y	2020-02-12 11:25:02+05:30	\N	2020-02-12 14:25:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
9b3Zu7TR05488002D8QB4146fndqRy3qSPUJQU407Bb04uPbFOQ02MS03ef3	2020-02-12 14:25:48+05:30	\N	2020-02-12 17:25:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
J53kAb59uTnTu815LT2wTP28bPC2MUPb4252f7n93E5f4PE3M0C3P251H13f	2020-02-12 19:42:02+05:30	\N	2020-02-12 22:42:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c039de78-d396-4156-94ef-11f67c5991d9
1C8XO53xEjSy0etEoY4c1Ifc4Q6545r7ufIIIabf2d7Co48400ljUc1ueU85	2020-02-12 20:43:27+05:30	\N	2020-02-12 23:43:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
H71CzHBGK8K476omND5qG1QC5Lob4H517W31fDX1b55z5XqqQUl7b5XQ7b6u	2020-02-12 21:09:29+05:30	\N	2020-02-13 00:09:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0	c43846c6-69ba-4161-9f06-a5f801791796
S533wJ6qrtncwRKsRFegSeQd96XKlh561R50eq0d50sRbm2X20b54ZGQ0bZA	2020-02-13 14:13:17+05:30	\N	2020-02-13 17:13:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
75i1ra114u4u88f87hR472c8OPETm62P1g78a72Be026Xa5Rujrnu128eq91	2020-02-20 13:07:28+05:30	\N	2020-02-20 16:07:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
10r6xMLkUd17Z2L7Y2183751YwZML01btfe1RrMb50JY1pyf1261769hMUiy	2020-02-20 15:03:37+05:30	\N	2020-02-20 18:03:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c43846c6-69ba-4161-9f06-a5f801791796
2f7peq0cMe0S049c22SfVQc2Q47LJ3506qcIPme422222e962a0NC3V6Dclj	2020-02-21 13:41:52+05:30	\N	2020-02-21 16:41:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
p8dz5f5Afqp19HWfUGB3zHfqFBAY72BuAan5N85f5fIDhBcdYdqf8qzzM0I4	2020-02-21 14:58:55+05:30	\N	2020-02-21 17:58:55+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c43846c6-69ba-4161-9f06-a5f801791796
8d04V8vlL9RcQ02QcjlR0Qn3cUd5523h8fO1mkl812emUXwLeL23atQd4mi0	2020-02-21 15:33:54+05:30	\N	2020-02-21 18:33:54+05:30	10.178.2.36	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
9232482o0ubDuZ022m543o1idx935Ge21ty93yVs28A8828bS92oX34y9zw9	2020-02-21 16:04:44+05:30	\N	2020-02-21 19:04:44+05:30	10.178.2.36	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c43846c6-69ba-4161-9f06-a5f801791796
3RAgiruuo8Ap1S8L03O4l3p05l4re5gLL82L2K3433522uLf41g3Fcpb35Sq	2020-02-21 16:05:13+05:30	\N	2020-02-21 19:05:13+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
iGc4OVicvhD9e5F8rhX1hK5QraJzh2XeU99zABcapi5c24cnQAv5nORnT6a8	2020-02-22 12:15:09+05:30	\N	2020-02-22 15:15:09+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
nD4ac2p7aB996r1W81I3Yf9PDSVY6IY669WUfYjW67aDE503ajVBj5AE8ccE	2020-02-22 15:16:33+05:30	\N	2020-02-22 18:16:33+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Iy2lQIw9ZaQCcK5LuTNls7wKZwQuuEwZZ6ZP1DYG396i9aI5w23IG325eeaq	2020-02-23 17:34:58+05:30	\N	2020-02-23 20:34:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
0LRyT0OeN85ZODzQk68g6MA5Rk819y51q5I6v98nele5DeA1n54u2p85x65A	2020-02-24 11:35:18+05:30	\N	2020-02-24 14:35:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
7EsN0n0QN11004RaeDf93LA7e1eTC5768dZ69721vW9784CL1e4I5wR5Zs4s	2020-02-24 13:13:00+05:30	\N	2020-02-24 16:13:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
gb9YOJ5HR791T4i39iPyneRf393N33a35VnvYc5eN33aI9yGY3HP54m6G5f1	2020-02-24 13:16:39+05:30	\N	2020-02-24 16:16:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c43846c6-69ba-4161-9f06-a5f801791796
803hA5HzVj0VJcOxecQA3n9Kenz1T3e3KM63A80VEi67zxK6zeJ0475Vj017	2020-02-24 13:18:10+05:30	\N	2020-02-24 16:18:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
gdaZc2zgA35m614qOaM6H50SIZ2b11tg0GQ1SsJd1j1340McZ3SgJ07F6sZ2	2020-02-24 13:43:51+05:30	\N	2020-02-24 16:43:51+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
Kz4C71581EBNJFlTK5EBJoUejnTh2N78ieRnrcqkUk4BFdoD5F76s47QrU2T	2020-02-24 13:46:58+05:30	\N	2020-02-24 16:46:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
3epE55ex9hJ9Xe4ea5T2oE82R21G5a2eldsZRBEdeEp5kcqxEZ8zL6xgJ38z	2020-02-24 14:15:25+05:30	\N	2020-02-24 17:15:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
lFFl3YeazH136FFR8K53a181cf15809G1361Ab21O9sa10b9wlHiY5ee5l60	2020-02-24 18:16:20+05:30	\N	2020-02-24 21:16:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
on5Qq81FWfe7qBHBV54N547cDNf447Y24675115U8HN4w7Vt2xtH5a8wJfe1	2020-02-25 11:41:56+05:30	\N	2020-02-25 14:41:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
5ZdR4u796u5n5J75CG51g0eGV23me69882d81fe828G6Hd14G3C2d1THu5pL	2020-02-25 14:46:13+05:30	\N	2020-02-25 17:46:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
a5zk9CTJ4oZXCnknT3Eg1YqnQ95d5Zd54XTJEX5g1ZJ252639X5Kv0efX25l	2020-02-25 20:47:49+05:30	\N	2020-02-25 23:47:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
1DZNQ57Mf7pMQ1a2J9a0v1lt6aZ5s6EJs9FtsvvQFpJn1t1Q6P9ZCpcD6J0M	2020-02-26 06:43:11+05:30	\N	2020-02-26 09:43:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
3Ucmv6O8U6v3r66v5OEyBHV88a86O35c8qUUE5VKR7c9eaw6zaEvYV43K9c9	2020-02-26 06:58:57+05:30	\N	2020-02-26 09:58:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
h8GJI67os6M2KN2GkTLDG6fu14912HG64xb5dwLHT56GPPM75gHwTwT6PaWG	2020-02-26 18:28:55+05:30	\N	2020-02-26 21:28:55+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
T1VRl5P5OJbfFFb30P7AD580eLeRAb0TAsRA1vTbkV4PKZMFV7P0RyH554l5	2020-02-27 11:31:56+05:30	\N	2020-02-27 14:31:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
q960l9a9a81S2SV65h1161R9t8079h99e4605M671RS60DhV86aM4t8aZ5Vn	2020-02-27 11:53:19+05:30	\N	2020-02-27 14:53:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
XH855R5L6a6Twr22f8GtzG071556436GS50iB8BOotLp1BzGaIO9HwpG87S9	2020-02-27 12:00:56+05:30	\N	2020-02-27 15:00:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
p1T90E22un638e8LMG6vH2M266L126Lu9H4n64O115GbVy11jijEy8G3a05R	2020-02-27 12:02:02+05:30	\N	2020-02-27 15:02:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
71gW2wmam1a88h6D347K063531L374x1BC22FF17ph0X5388FWl5uy9575Ka	2020-02-27 13:30:27+05:30	\N	2020-02-27 16:30:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
46v7rre7441Aet6el7ENo6u8BI15BGBL97w5Al6tI45zA6aV76oXB5V1fBda	2020-02-27 13:31:47+05:30	\N	2020-02-27 16:31:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c43846c6-69ba-4161-9f06-a5f801791796
wFl41z8lC5J7G85145r50Monc573p85rdk0e5J49unca0cedc72Cr501Fu01	2020-02-27 13:33:33+05:30	\N	2020-02-27 16:33:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36	c613e2e4-84bc-4ccb-95e6-f7a8ca624a25
585FbYhI25ij1cs3AB0j87cbdfum75V6rm2oRVHC4c5zz67Cn6A1Hz88mOu3	2020-02-27 13:34:07+05:30	\N	2020-02-27 16:34:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
742hDW6VjVj3x35653hddOjYthk4PRCQPhDtCwWc6CVT13Qa7CtCCRfX9bC9	2020-02-27 13:39:25+05:30	\N	2020-02-27 16:39:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36	80bd49f7-a31c-4902-88f0-16cbc9740c8c
zKO3YM8L00Y8YKyluziy00G22MuD2kLJL6KA5V8dst80sDCil7CdOs21Ut71	2020-02-27 13:58:24+05:30	\N	2020-02-27 16:58:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
8d2E2Zk0I02ZrfyaP8a37yU2i4a1250N4d4K11ndf8gVL8ireiTd05a33WaD	2020-02-27 14:22:45+05:30	\N	2020-02-27 17:22:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36	c43846c6-69ba-4161-9f06-a5f801791796
eHWV7F9yeHK0cI91zVB9L79TvfkVr80k939X81Q40hbQHFfahFV5rkFP5f2V	2020-02-27 14:29:52+05:30	\N	2020-02-27 17:29:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
6Uz9z2o1y9VlzNO22676945Oz75kqDz1KqzojCCjlCdL17574EI5detCdv5z	2020-02-27 14:32:31+05:30	\N	2020-02-27 17:32:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
75gLqGS913bbhGv3VGg187XE73yy581277Ha31rf4b91NjwqE7CfMl4651yK	2020-02-27 14:38:54+05:30	\N	2020-02-27 17:38:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
F7Lmbbv5a52DhOKj5TJTB7F1Bq6AfP7z3n828m2K1l28h5qqTq5Nd7D6122v	2020-02-27 14:39:18+05:30	\N	2020-02-27 17:39:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
m6YDAaadb1DD75Mg6OW1xVemQD5HNI11xdeJbymF6AJgVO1K565ddH15bDe0	2020-02-27 14:41:06+05:30	\N	2020-02-27 17:41:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
ekJvk82JX71j0k6D77MDXW5Ve2oXONVu5V80999Nat662e1M856cdvNd9k16	2020-02-27 14:51:19+05:30	\N	2020-02-27 17:51:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
SMrA82CVSR51MVP4M8266nAep1YSn8jfuijH1AH5XDu68LhHDaqR2h1Aqpn4	2020-02-27 15:14:41+05:30	\N	2020-02-27 18:14:41+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
1fe6kT3R1P7e9l137k2nar8bR3yQ7k304zP315vZdh1PZc32Qk5vNIRM8wv3	2020-03-02 12:55:35+05:30	\N	2020-03-02 15:55:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
IN2N1w8FuaAAlVV52bcoSeNVhw7eoAs59gKahu0B0hP01j92wV1N1o0VF558	2020-03-03 12:38:39+05:30	\N	2020-03-03 15:38:39+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
wU9T5k32332kyCy0B29uf2k167Wf4VRq2U1e96Yjr21j3503962IQs33q5jx	2020-03-03 16:16:01+05:30	\N	2020-03-03 19:16:01+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
h303i5mywl2E2Y25dUa8iV28tiNY88geaZF5dkr27BXVea4q5Y2U8HmN1Edg	2020-03-04 12:09:41+05:30	\N	2020-03-04 15:09:41+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
nmjjr2t4mSgXXe3e64Xdy83cUM343yXW35b4q1jfKNmeXdLcU44AQNSyU44x	2020-03-04 13:25:47+05:30	\N	2020-03-04 16:25:47+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
4eo9V3513a30y02ff070D3D77CAzFzrR3DPPP6VD0f71921m3673SHsDj6pL	2020-03-05 12:38:23+05:30	\N	2020-03-05 15:38:23+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
j35321E9f448t8Y9ee8eee5G63e21Mz033XS5HKyMaXM55emMHGd1j0ejmmB	2020-03-06 13:06:53+05:30	\N	2020-03-06 16:06:53+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	c039de78-d396-4156-94ef-11f67c5991d9
s7wOws225Idguagmc852x9j7jcu0sI6xqwgN2Haax5e35woOodM1c82gbu3K	2020-03-06 16:27:31+05:30	\N	2020-03-06 19:27:31+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
3uutX3ZFZfq5xUuu2nZ3ng63O4rwn5835Z598tQR5n1xqXnto8Q2K4LrOr6o	2020-03-06 16:52:05+05:30	\N	2020-03-06 19:52:05+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
m4bi0C1A4dce9dt0355cunLbzSfUy9Sbm42tdMt4Z1zTt0L3t95ZAb2Ot4A0	2020-03-16 12:01:16+05:30	\N	2020-03-16 15:01:16+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
20gS5Y44Lz6eE205zy5LD7yE495S0e3159e4571YP20DOIej4024G24lI53y	2020-03-16 13:24:31+05:30	\N	2020-03-16 16:24:31+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
ld265ahWbX534250b42x4X3PPaYH3176WWIa2G26p1HWO4x0LZ6yx22I12h5	2020-03-16 13:25:29+05:30	\N	2020-03-16 16:25:29+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Z1Ib613143fp754u41h2eb4178q670ZI4Vb1J9hZLb4pqI5fek7zuP4495L8	2020-03-16 14:09:43+05:30	\N	2020-03-16 17:09:43+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
b0v8SXf0bu8wqOM79yes415e15bQR9Mb5tQ2e3WROXRbG5o0882GyI310B15	2020-03-17 13:24:00+05:30	\N	2020-03-17 16:24:00+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
M2E81oeZZ1DF433p22x8G2447PXef617of4LflFg9W17o7L8BO0817g7pktp	2020-03-17 13:31:27+05:30	\N	2020-03-17 16:31:27+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
3k2v9Q4L85ARHanf49ng3Qtgbu31ef4Q7s1x9A31qWUnv1ae55418J6Jkvl4	2020-03-17 13:51:51+05:30	\N	2020-03-17 16:51:51+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
q45jOOo993zm1v8yVo3bW595857KRBqW07Zf11m47YvW26K538F3v789wR1F	2020-03-19 12:30:07+05:30	\N	2020-03-19 15:30:07+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
5V0a15QpVff5Nh10fMIah2fH5m67ef0X3ZRfycyhV15yvk391yZ3RhO7175e	2020-03-19 12:58:22+05:30	\N	2020-03-19 15:58:22+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c43846c6-69ba-4161-9f06-a5f801791796
4alpn7P4Ven6j1v001PK1s0JeVJ6aK00HJJmDsB1XVen5l53e3C1zaz1Jw0V	2020-03-19 15:35:30+05:30	\N	2020-03-19 18:35:30+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
jPZ020HzH812Q103C7M1501412HfYQ7NN3bd8yPVzN7MuCdZG381r93DUK41	2020-03-19 15:42:00+05:30	\N	2020-03-19 18:42:00+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
aUUa81mmePnm6T66oIYk49U7Nox578IC86Te4x67ex4uee5445wLLu98038e	2020-03-20 14:28:14+05:30	\N	2020-03-20 17:28:14+05:30	10.178.2.133	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
c99EQ6clhP0EM9rd4rM8r99v56Q89B519gYu5848Qm1Jch144ugJGxnhQnDB	2020-03-24 14:33:44+05:30	\N	2020-03-24 17:33:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
q5n5C5KKstm3ga3chSuT2S2rAa1g5c8b2BVKK1acD5518uKWu8zCC35KScK1	2020-03-24 19:48:18+05:30	\N	2020-03-24 22:48:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
y01CU0xd9U6G015u0hSWI8Fd1fy4Z8V619CV858FFyAt8L0w6x6wCC0l87J6	2020-03-29 11:13:29+05:30	\N	2020-03-29 14:13:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
T6i5TnI76Hjh64XHxSTlIvuUD2JN5X3kJ34hdhvO5l4Hh87vix00Y5jW1802	2020-03-29 15:46:13+05:30	\N	2020-03-29 18:46:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
E8K1b7w5h4kmVf81Ze1xVKbTr4UP05P7850C444746xn4YV35kI6r9b6Qm9W	2020-03-29 16:47:56+05:30	\N	2020-03-29 19:47:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
04a8BZcCK0scx3k1M5Z4V335Z1Sz0a0KeD8Z2Xa18a8k3jZXw1q5K3KxsP8x	2020-03-29 16:48:33+05:30	\N	2020-03-29 19:48:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
A76Nn5wGE7A954BjEfN4AB22ee0W38277H1f0B02uRIW4cnjff58680604Up	2020-03-29 16:49:07+05:30	\N	2020-03-29 19:49:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
720mtg6ZeK19l8t6TX6ma61DY7XwlJG0h6QO3s5wtc638t0KL1eLtbZDR3b8	2020-03-29 16:53:37+05:30	\N	2020-03-29 19:53:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
HFQA208910W5CX3JBXDz553CZ08Z4l0s0sXr7Q5JX959p10T53GlJ3QsDN08	2020-03-29 17:10:37+05:30	\N	2020-03-29 20:10:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
dw1d570Fp0O811Ufo7F5025qu8W3nf1n5bz73dwUho585cfqc5vd0MU5VnqA	2020-03-29 20:06:02+05:30	\N	2020-03-29 23:06:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36 Edg/80.0.361.69	c43846c6-69ba-4161-9f06-a5f801791796
jb0VLB3unj3zLU52z2u8L085SB7FftS5Leje8DFu019S05DeeSeUp2JR5KL3	2020-03-30 09:56:54+05:30	\N	2020-03-30 12:56:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
8pY8jz68sB14PY75YQMd8k345O4YY1pB167N8cHw5H15eHgv3ivbSe18lsM1	2020-03-30 11:18:36+05:30	\N	2020-03-30 14:18:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
5FAKpG55w5c56G7G2Tp5TSS2N2x3c8Rx7528N45w5Oa0aSRADl4SDITSNR7p	2020-03-30 21:33:35+05:30	\N	2020-03-31 00:33:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
76UQa9M5Maa59Zan16m6qGiH51m66J81hMPSEh6e83ef6uSO1feMccZSOM6G	2020-03-31 20:43:46+05:30	\N	2020-03-31 23:43:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c43846c6-69ba-4161-9f06-a5f801791796
kVp524i6zZWSe8zty4TNzirU3A9l23I22eNAE11z55la6tNy5i6yUS95lkzI	2020-03-31 21:09:15+05:30	\N	2020-04-01 00:09:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
1H5617H584TIpd31Lv76G6325L358118e8n6BH11O0li17gxGULk35llxOUL	2020-04-01 14:55:44+05:30	\N	2020-04-01 17:55:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c43846c6-69ba-4161-9f06-a5f801791796
c7ttUehHcJLjo19LKBz95MB2eEBpPMUHR5ja5KJHk2JJ4e51tHMNhc5zPKH7	2020-04-01 15:35:50+05:30	\N	2020-04-01 18:35:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
XvQkQQK41285teeaefg7296s03a5f11DkL9te6VyBVctx28g5mRkvtLD2X5k	2020-04-01 15:37:06+05:30	\N	2020-04-01 18:37:06+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
TC3V46XM6O3Z7GC6Mp07J8055jqmJMG4a0W337E4OnTp1k5ZTj89544P49Im	2020-04-01 15:42:29+05:30	\N	2020-04-01 18:42:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c039de78-d396-4156-94ef-11f67c5991d9
ojQ28g457ee4WvD818e610nO0Ad2iXXxo52en11vN1DA50ed7YebJ8enoi77	2020-04-01 15:43:50+05:30	\N	2020-04-01 18:43:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	6c6ca4dd-0ef6-4584-8d01-ea922578fa20
7wd0RjR5a1aEv07r9IE00dLYPk6xn0L034xHYRD5yrUdxUnmb519wjiI9cKe	2020-04-03 14:32:11+05:30	\N	2020-04-03 17:32:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	c43846c6-69ba-4161-9f06-a5f801791796
3fjR580Wfb31f65nuaFbbyDJM6a318JA8F3Mu5b85n515FEKz3Lc0005EBJ4	2020-04-03 14:32:34+05:30	\N	2020-04-03 17:32:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0	6e6cae79-b531-4596-bcbe-4cc5522c1536
l554q144uy2qa5m45G5iLafu151va485XX556qzkVLX7884u5yXXfD5X16u3	2020-04-06 14:50:31+05:30	\N	2020-04-06 17:50:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Safari/537.36 Edg/80.0.361.109	514d2016-34ff-4a20-8277-d61af58a171a
1ZXBL140Lcye6z6nZfM9hi653Y6t9h2dFXX2grbLO51jn8t60zigi6oLbh18	2020-04-06 14:50:46+05:30	\N	2020-04-06 17:50:46+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Safari/537.36 Edg/80.0.361.109	514d2016-34ff-4a20-8277-d61af58a171a
ZCe1ce98c6i2s26e67p85l2d8PTk615i8r268R8s5la1AeS65288AP2Bn631	2020-04-06 18:22:36+05:30	\N	2020-04-06 21:22:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Safari/537.36 Edg/80.0.361.109	514d2016-34ff-4a20-8277-d61af58a171a
nG6D7ccJS1Zi6jP6JV5qZA15uJfJbnbYIX847V6o2nW4e12VJ2n8QU0epKtQ	2020-04-12 15:46:36+05:30	\N	2020-04-12 18:46:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Ai353AU8w3TabS6wt6e5886sU05b1b0B65BeIH514OA6KhnBrT220ugtfAe2	2020-04-12 15:47:14+05:30	\N	2020-04-12 18:47:14+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Std4wDWACIN0SCIEbVVS78bqA8452VgZY00p1CWyVc2b80O0OVg8C4O9U00g	2020-04-16 18:47:58+05:30	\N	2020-04-16 21:47:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
Hci52121qr000d25e8qa9L1Dx2xE08ntR018d55kdaXxrfDS9S88WieEMi81	2020-04-16 22:03:32+05:30	\N	2020-04-17 01:03:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
81Auk358XJT61vbuUINnX36Jkx5R1r9zfj0a32vP9DOp8O0eA1TN6vhD0h1u	2020-04-17 07:42:10+05:30	\N	2020-04-17 10:42:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
0279YR9gg8sc9t973fzVf19124gyrcDc1B44Hc0mgHZ2f0TP0E4t1Pb1i4Y6	2020-04-17 08:36:04+05:30	\N	2020-04-17 11:36:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
EEW6gnAy30re49KCLKcCPc78x10fD8Pv7452w90c59882Z92Ea22yCEunJC5	2020-04-17 09:54:17+05:30	\N	2020-04-17 12:54:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
1AfZ25ok85115x85aEEsw72265Zgxw2HdsDroE62d8y671ia2y5a176y5x79	2020-04-17 18:44:10+05:30	\N	2020-04-17 21:44:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
LeYUUjtO0YC96U53jL5aNM55Ec12w1D3MjEvYe9W9WWDc15Yz7j2259OY18Y	2020-04-17 18:57:45+05:30	\N	2020-04-17 21:57:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
8psHl5YK5m1ezLaO5g95rlRamX7yHYH0HnyHszsebj50HaQ718OHH777IKX8	2020-04-17 19:01:19+05:30	\N	2020-04-17 22:01:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
882uD0Obbw9403SS3s4Hfx050b4g8J3PH0bLuLRx9d5820556G4W8GibRf07	2020-04-17 19:07:01+05:30	\N	2020-04-17 22:07:01+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
635d1NHbxh4a0cxwch8laR9q7w9iixhcT5W4HvvRJ53911al894G33b901Ne	2020-04-17 19:13:15+05:30	\N	2020-04-17 22:13:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
M8515eb5aOVO1X5QEQOssM1fh33eX5bEOu15fL5Xqr9XYb18750zm901121b	2020-04-17 19:14:53+05:30	\N	2020-04-17 22:14:53+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
5TVx72fFp9b802yZazbpwZllXa3D5zF1FKwsgO18z584fflag85NgwTo312y	2020-04-17 19:15:22+05:30	\N	2020-04-17 22:15:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
99Z2177f5V53X6f00q59gUT0q5resb505u53w8A263U59AssF7rY0590ssP4	2020-04-17 19:38:20+05:30	\N	2020-04-17 22:38:20+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
2dc8k4Rl1HHLsl8tXH8209099at4jD148Ss14Pk8jpPs5P2652pz5P84ja40	2020-04-17 21:46:30+05:30	\N	2020-04-18 00:46:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
kze9NR1YL5041RV7S91yS4rLQsbe79d0M7QVA1LNFG457N2NF1lnW9s1rSNM	2020-04-17 21:58:05+05:30	\N	2020-04-18 00:58:05+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
eccxAzQ9Aw3Hfz8w9veJ3jz8Mj865817j4kuS7c42534MO259eJV5772nt15	2020-04-17 22:38:38+05:30	\N	2020-04-18 01:38:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
5545cWuBspUFy9U60x408Ds3A97x95aEiDQDUAUS5DEs7HT7H0D88EP04F7F	2020-04-17 22:50:07+05:30	\N	2020-04-18 01:50:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
343168896yq83SqabYbn8q53qZbA7bmc514abqagAJ0j41LaJ6y1kEEvJ48k	2020-04-17 23:04:04+05:30	\N	2020-04-18 02:04:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
76166LmH3yLW8m9tvTUgBoU8c51mE1ia5L8Le1GUqe4Uuoig4M91M1WiM51o	2020-04-18 05:57:39+05:30	\N	2020-04-18 08:57:39+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
Zlvz3BL468k7Vv9YBBAv76qVKTBzLwxwT1h5sXIXcKi4wxDlVpw75xZuV857	2020-04-18 06:24:44+05:30	\N	2020-04-18 09:24:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
eaZH19561ZV473zal7Y14pt84Eza4D7sw9Uws3hbg9wKB83t1p351p0eh98h	2020-04-18 07:00:38+05:30	\N	2020-04-18 10:00:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
Z6O8DDtZjo30GD3181Qv30y59aL5837L95RcT3Ue0y63997jj7Ucv06n51L0	2020-04-18 07:09:56+05:30	\N	2020-04-18 10:09:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
H4HAgR651zuqb66T6MKq3QM3UgsYU9Ms3gdqQTRIooATz95s8GUQ55AksEMu	2020-04-18 09:44:36+05:30	\N	2020-04-18 12:44:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
YSrNLvqa5qz88dFQh7kFdU851N9eLv9lWhTGLp1zD15799W8NG2dk2TxUdlh	2020-04-18 11:07:48+05:30	\N	2020-04-18 14:07:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
vfb06v0h5SeTP7f6eweh8f88J2zsy56419ws74J1fRI5mIh8eaUrb8hhbNrP	2020-04-18 15:10:44+05:30	\N	2020-04-18 18:10:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
f4Qaa785e9d0P9w6mPgQ1jccOJ1N5aKI6n842Eea9Z7Q6J9tOmZ9c81Pt5mj	2020-04-18 19:07:15+05:30	\N	2020-04-18 22:07:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
2sjOb1dfbdj1dkeV611dSbzXvvUedUv612eeeLDMyrBZQzA0d269v577yUQ1	2020-04-18 19:08:32+05:30	\N	2020-04-18 22:08:32+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
7R5ug21gOZ7O3a6W429a33l23a17H8gqszw7mA32iHS575y73mIqD1qO19MS	2020-04-18 19:13:11+05:30	\N	2020-04-18 22:13:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
OceC00e0PPz0B37L2jB829l4axFFQz0Gcr7bz2b8tls301hwe2Z554NQ9bPj	2020-04-18 19:50:15+05:30	\N	2020-04-18 22:50:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
9S1L5g0255bwc40G8b5u0KbdXxK8s04X0he1nUbr76422uO5865c50bG5l5h	2020-04-19 06:39:29+05:30	\N	2020-04-19 09:39:29+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
9gwbC6cJ8mh655gGw67R76966W7986F1z29128J7hf8PQ5gQOGG5m2657f0Q	2020-04-19 06:44:58+05:30	\N	2020-04-19 09:44:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
8Dw8Idr2a9eh26iY27Eu2DV9Vq0YR86nSl9SeW0VXdT8NrLIr726112VhXQt	2020-04-19 06:48:22+05:30	\N	2020-04-19 09:48:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
3eF96Z5f2RF922Vo9edr9S5Zo5Iw8NAJNg322R5C9air6hZ6g52Md859C0bS	2020-04-19 06:58:19+05:30	\N	2020-04-19 09:58:19+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
Pb4Sd4Z805ww9MdZ5T76h8Md0Tc14E922oJ99bd34qne8EF9dy61C35Mb8bh	2020-04-19 08:51:26+05:30	\N	2020-04-19 11:51:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
7HV36x02mxHTN66uV05HHc6t70ab5feZ75MZe26S1mfUz0N3e80cmASC45D5	2020-04-19 08:52:18+05:30	\N	2020-04-19 11:52:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
AW19m0xmG2vAml53A0p01J08W02zGAA8m63ddlXe8z5Y8H2xp12HhX402JM8	2020-04-19 18:50:36+05:30	\N	2020-04-19 21:50:36+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
4H9e0cVD4V8nQ024U7QvE3n0J72Q951UG21MC419nJcnnnK95d3JcHuk295u	2020-04-19 18:53:38+05:30	\N	2020-04-19 21:53:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
uM224T768D92v8DiT21wDeN5847jx8DToy1M1bYDuNSrZE417jw5py5N8VDR	2020-04-19 18:54:00+05:30	\N	2020-04-19 21:54:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
hvcw0VHoh2068R03845F040VH0bVFROjjV86EsBELHH9060V1H80u988s7b9	2020-04-19 20:01:24+05:30	\N	2020-04-19 23:01:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
tL8bcc16T7ro14hBNTrA8Use3VgU6dyUB6t46PrbNu71UFuWA1y4dWJ79ed4	2020-04-20 07:37:31+05:30	\N	2020-04-20 10:37:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
x29Nji0et32eL3gvc1gT30v18juGcaB9c26J181Yc357870WG3519J82Ud3j	2020-04-20 09:45:08+05:30	\N	2020-04-20 12:45:08+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
dRevg4J15FI9119FO497Hx2CFgWx6cSB5o9b9Spv0rF4J104SF20U9YsG14H	2020-04-20 10:07:00+05:30	\N	2020-04-20 13:07:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
cSyD2kdA271W3h75k1Y7G334qdkYD5Y5WJ6d7WeO757Yq5G6AW6g75KqqWwh	2020-04-20 11:36:16+05:30	\N	2020-04-20 14:36:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
If2CSA0gQwaE4lb415SOSVNUWS570I4g888gbIySbOp95yqb70d0OAx8980b	2020-04-21 20:32:30+05:30	\N	2020-04-21 23:32:30+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
jwfJA7J8BdZ28cZv76b7uO4cd28rJ8ZBs8rfwTO2j6w7d2uv78JZOcT72dwj	2020-04-21 22:12:38+05:30	\N	2020-04-22 01:12:38+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
v89xXX3073f2r9ARLBYyZ7EN7Uw5sXcD4Z3wAL9Yl4IeL714TTUX49yx891y	2020-04-21 22:14:50+05:30	\N	2020-04-22 01:14:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
2d8f21fSS8YeS4XxiY0f2862A22SW6vTTZf4xC5ZY7M2Y4QM18t8I87rvdAr	2020-04-21 22:27:44+05:30	\N	2020-04-22 01:27:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
824a1vZ6le53ee9al1J0XNS17jbJ54r95aOBxStOBt37L50G131y3ffbN9iJ	2020-04-21 22:28:34+05:30	\N	2020-04-22 01:28:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
ilPoxr2PG2B2l95ib7xqqMGcIG3knielz5e5Ui31k6kQ9dr35qdA3P5fr51I	2020-04-21 22:33:15+05:30	\N	2020-04-22 01:33:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
YPs738B1aYReRPTj1as9UBMUPsQfA9Mi34HE8Rbq8U9iG3A547D798s591c1	2020-04-21 22:34:09+05:30	\N	2020-04-22 01:34:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
5X92I245fV3ff7772r037Ha8R13H1QE7tE53J725Ip29r4E8N58C3K3XI710	2020-04-22 07:08:27+05:30	\N	2020-04-22 10:08:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
Ysxf5Y1N5YmXYNYY1XYaqBK2a6yY96csWmf1y6f7i9asw5KKN13BEBxJs42f	2020-04-22 07:18:28+05:30	\N	2020-04-22 10:18:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
62z2XvxaU6Yd44KeA66xXfCZCL1Mnfd9eG2CO502LLAAKfZ6Uw29gb6f731w	2020-04-22 07:20:42+05:30	\N	2020-04-22 10:20:42+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
YL8qjxx760D7Wuy9fx6Du4b2782fE7zbb7e112xw29u95hCqq0o9OS1L9838	2020-04-22 07:23:22+05:30	\N	2020-04-22 10:23:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
21FRb2Rc1d4Fwi5ne55hfa1xYbb2wKb3H2q45390msS3x4553ck6V19biasK	2020-04-22 13:12:35+05:30	\N	2020-04-22 16:12:35+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
Ra802V48ay5lN263y6n681HjXKMr655M00faFJjg63zg4f0y584rlwaM4aX7	2020-04-22 18:56:50+05:30	\N	2020-04-22 21:56:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
C5S7dphj35Zxffp20mwl51pAJ2x8Hbcj5UlcCcGc1r7965e2ZLf6h1x8Jb9N	2020-04-22 20:16:17+05:30	\N	2020-04-22 23:16:17+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
k40x5cP322a33B896jZ6auuknJ63Z9q112fnp8f3c387l14B6un6873b1g6x	2020-04-22 20:17:24+05:30	\N	2020-04-22 23:17:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
r5ajBiDQ188uQfXv1q9ma9FkaaC9uE1250B1Er9zi277e0S97971b0Df7jz1	2020-04-22 21:42:09+05:30	\N	2020-04-23 00:42:09+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
l18ay475qevMvd9v956MlwT8Te9vN6gQqWg13Vre11jq37QD33s9fHHqbfTM	2020-04-23 06:25:59+05:30	\N	2020-04-23 09:25:59+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
j618mQ0peie02P0nV0e00A022q70U8m4hl7FpXFl3p8KXWee5a164jQF57Ua	2020-04-23 06:34:34+05:30	\N	2020-04-23 09:34:34+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
1i2GA9t14jNo3T139id965ew71d19zeTz1vvkj89KBMXutz3hg1856hjM238	2020-04-23 10:06:31+05:30	\N	2020-04-23 13:06:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
94hUdq949aU59IVi266h41J0e7gd942P5BUi2g0gm5M6i249339siV606VX6	2020-04-23 11:53:43+05:30	\N	2020-04-23 14:53:43+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
yE33672StiYetJSyAewJuY0wttW4o9ArKOQQWM07lbdiZjG4yAlj447e3j88	2020-04-23 12:04:28+05:30	\N	2020-04-23 15:04:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
AAQx751853TD4Cx954kj50blkwG53tqDb17465N1j52vjQBxcE5a5Qb5a4by	2020-04-23 12:09:16+05:30	\N	2020-04-23 15:09:16+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
OkUXua6X4Ue71408GlU7d80d183Y7f898oZb19bUa8o0bal0o71125VXao19	2020-04-23 12:11:15+05:30	\N	2020-04-23 15:11:15+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
rD23jaT778JSFSkeTG75o1AXp7423323LTCcg47GZT0X0coo12106Z2X042S	2020-04-23 12:18:18+05:30	\N	2020-04-23 15:18:18+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
8Yd52oeMeMLWoU226796G5HegR3B15W9213F1fL1Wa5M1Bl972j2UmoeLC3f	2020-04-23 12:20:22+05:30	\N	2020-04-23 15:20:22+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
G87n56e18O8LFt5cXZa7LYo3GUn6aM4FU6aSHZUUq1lr3Y8b15S1L8a8ZOU8	2020-04-23 19:43:41+05:30	\N	2020-04-23 22:43:41+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
x811Nx3OG741T3l4ABaPXMpSp2H3Y6SDlp7X7QN78mN6VOpYa9W1sy9i35mY	2020-04-24 19:43:58+05:30	\N	2020-04-24 22:43:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
YHQMGk523AAHg7JgO739yZJXA5kk4584MAkGSM7JLAPo5QZ3kXlb4AN82xa3	2020-04-24 19:56:26+05:30	\N	2020-04-24 22:56:26+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
ee3K5W3mb4HjnaKSWN355aa8jwcrHN331rz43155gP3v1rcQY75QfQ7K7d8r	2020-04-25 08:12:45+05:30	\N	2020-04-25 11:12:45+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
jTDeCKm577R3HnN8xD30t6B7ei7aqycce0520fyjK17epcL17j554e6431ak	2020-04-25 08:31:50+05:30	\N	2020-04-25 11:31:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
z1OO5E56eO7UatumU60qM97ujQpu1k1zr3c77pd1ukaBa5t7H01ut9A0wQdE	2020-04-25 11:57:50+05:30	\N	2020-04-25 14:57:50+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
5G5G5Zeq7e8BmPdeKm1O3aCa6HCBG6cH9GN69GeW3n6HanF65ZR674aRh784	2020-04-25 12:07:24+05:30	\N	2020-04-25 15:07:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
75nr4iaJ2c7AD93eaVs83B1h583sHee69i7pYMArKrdrZ3YO68Vza9H55468	2020-04-25 12:09:54+05:30	\N	2020-04-25 15:09:54+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
2f2R5pLtv9fWApt559R1882Rp90fe92rdUDq5Lv82dR51871neA92If8L9yp	2020-04-25 12:55:25+05:30	\N	2020-04-25 15:55:25+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	f238775f-6e77-4df4-871d-7fb6fe8112b9
7QaeE015fEecFi59e9i54j7J4jF1CBcVL0YtM179jh5HnTV4efl8JEacb3yb	2020-04-25 12:55:47+05:30	\N	2020-04-25 15:55:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
eJ78VcUc58797mmV91N49m1X57M8477fefUASseb2aS7scm799nkkkaS9V42	2020-04-25 17:47:56+05:30	\N	2020-04-25 20:47:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
eqOzta0a8pQgOq4KBJ18SgNJ1tf1Ua5kOO1aW0fNzOdM1E0pg6vYMg05K914	2020-04-25 17:48:48+05:30	\N	2020-04-25 20:48:48+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
ZR85p5m861IfhlRvXf68d80w5t1MG47hgRh5S505XhUlpZpn6bl12h1DGGHK	2020-04-29 07:29:49+05:30	\N	2020-04-29 10:29:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c039de78-d396-4156-94ef-11f67c5991d9
feI4C692bxE31ixwRfbxiMsCbr6FSIx66CKn87X116cxw58SFF898SK8a1aT	2020-05-01 21:40:27+05:30	\N	2020-05-02 00:40:27+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0	c43846c6-69ba-4161-9f06-a5f801791796
Jt60h8Y5G1GY1ohS58he5ey501BT88thS0bBC5658G1b85B1xGhpK8895529	2020-05-20 18:37:52+05:30	\N	2020-05-20 21:37:52+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	c039de78-d396-4156-94ef-11f67c5991d9
98k6pkb67Lzea1e47616lSO7Jedx6lgA3A6eC9P473zld87yuRgb5981Jad6	2020-05-20 19:53:57+05:30	\N	2020-05-20 22:53:57+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	030c2683-8ff2-47f8-81fa-f05dd8657f58
6LMb5c6O07cR5BRe918fyCzz6gbO52Mn85fz006K0e5nMY066nbMcyL66cON	2020-05-21 07:28:07+05:30	\N	2020-05-21 10:28:07+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	c039de78-d396-4156-94ef-11f67c5991d9
K1g0bY5Y4ugc2mlTtkmYY0k5Mfa0U1Wavy4W5e8RBXV338TN50E017t980rM	2020-05-22 20:04:44+05:30	\N	2020-05-22 23:04:44+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	c43846c6-69ba-4161-9f06-a5f801791796
9mY717Qc73e8rQQB5z8UP1373c7gRaxwz6IQI999fRPQQ33B7x7zS1cU37e4	2020-05-24 06:42:13+05:30	\N	2020-05-24 09:42:13+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
V1sLmgmUm5hKAGA07dxV9xfcetA0fE7iWTz0z01XSMHGviScQN8W5J119ff5	2020-05-24 06:42:56+05:30	\N	2020-05-24 09:42:56+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	c039de78-d396-4156-94ef-11f67c5991d9
7wI1fHO4NfN6L114e3C2F9d7f5Dlq0478K2CZu2Yq1w9jLuZrZH7489i2IuA	2020-05-24 10:20:24+05:30	\N	2020-05-24 13:20:24+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	dc6e8456-7fc5-472d-adde-28939b3da901
751o5iR9OF9nDcoeSiZS7JD95Nk2q55oy5f06o9g8ne9mMe9g5HiO2k67kn2	2020-05-24 10:20:33+05:30	\N	2020-05-24 13:20:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
R4jijA48hAIW4j6nSp5702SrCCrfYlwLlCQHb9IvN4z9Hc9hlc7H44QH56Yj	2020-05-24 10:51:04+05:30	\N	2020-05-24 13:51:04+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	c039de78-d396-4156-94ef-11f67c5991d9
h65Rb8hD5Q0EU1XU9fV9hFHFkM05M906dKaOe2bgeM200Mo0hkZ6Xo80e65K	2020-06-01 14:12:02+05:30	\N	2020-06-01 17:12:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
k22VBF3rT37Vd9Re7iY29KZD5hR17202bF2L59cdC99di5dx27YK3VuT12DY	2020-06-26 16:46:47+05:30	\N	2020-06-26 19:46:47+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0	c039de78-d396-4156-94ef-11f67c5991d9
N55379e3ff5ZWxf9Wye7euIK23F2Z35i219exuHu5239llLR7VH97917ZN89	2020-06-28 15:06:31+05:30	\N	2020-06-28 18:06:31+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0	c039de78-d396-4156-94ef-11f67c5991d9
RtkCnTB07EQ3rqq8ZEju6a5t39NCX3x6E59rXuBEQgRSgCy9an5E79Qo03Ih	2020-07-05 07:58:00+05:30	\N	2020-07-05 10:58:00+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
4HW571FOUKC18x180IJaOIKYfa2aF4RRXR540UIH0E78XFLSXRA37g1C8E20	2020-07-09 20:01:28+05:30	\N	2020-07-09 23:01:28+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0	c43846c6-69ba-4161-9f06-a5f801791796
P7c5660U2Y66N625ff3g22aJe4Is13x605tK6128Nccr2DtK6m7Qn05600yc	2020-07-09 20:21:12+05:30	\N	2020-07-09 23:21:12+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0	e4b7fc43-406d-437b-a946-a22d7bc52d38
xT711g6R1256V2fV91ue7Jwto9TubR9LeifX9VpLR75311ua11755g96fJ91	2020-07-16 14:23:37+05:30	\N	2020-07-16 17:23:37+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
56613Y6554589825t5y5z5Pz8nzdzw71101231P5Be7f41Zwd57n2qxk69o5	2020-08-08 18:45:11+05:30	\N	2020-08-08 21:45:11+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
cc4C865z35I59897w5Y76C2436H1siNKGz143c3J5T77745TyL4uH6mCJSK5	2020-08-17 16:06:55+05:30	\N	2020-08-17 19:06:55+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
0DqQVBvOZj61A6Ogfa4h65B8F9Dhh50B8WLHGDdiWg6v7OjIH5hO5L465R9m	2020-08-17 20:29:33+05:30	\N	2020-08-17 23:29:33+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0	c43846c6-69ba-4161-9f06-a5f801791796
9FfYArN1Oy5jU6ld621falMWCdAZCz1O7xYyT06yr2v1U46MD65004Ld6y51	2020-08-22 19:17:02+05:30	\N	2020-08-22 22:17:02+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0	c039de78-d396-4156-94ef-11f67c5991d9
xx8n95F085woE0b3hW285NZ9T8E05FU445dXY392y4MT002Dx5MFfy4NnhF5	2020-08-22 22:24:58+05:30	\N	2020-08-23 01:24:58+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0	c43846c6-69ba-4161-9f06-a5f801791796
19L194N542F4rdwPd01A2Pb94wo091951VW9TbwiFS1iWQ2N2xh31521STuV	2020-08-22 22:31:49+05:30	\N	2020-08-23 01:31:49+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0	80bd49f7-a31c-4902-88f0-16cbc9740c8c
491d8J485XdoAVPAv9vHgmnA8xu82o0p48Az88j7E0T5E8219d1O5ymhc1ay	2020-08-31 16:56:10+05:30	\N	2020-08-31 19:56:10+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0	c039de78-d396-4156-94ef-11f67c5991d9
bOIJ5Sl4sKKidTS5L899lsdjf4JBXd0kLBcLkfI1OK2xW4TeIwJLhZwfn4sf	2020-09-10 12:46:40+05:30	\N	2020-09-10 15:46:40+05:30	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0	c039de78-d396-4156-94ef-11f67c5991d9
\.


--
-- TOC entry 3070 (class 0 OID 17214)
-- Dependencies: 212
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu (menu_id, menu_name, link, parent_menu_id, sequence) FROM stdin;
17	Receive Applications	/Application/application_list/3/in	\N	10
27	Payment History	/Paypal/paymentHistory	\N	15
29	Receive Non-Order Application	/Application/application_list/4/in	\N	17
28	3rd Party Non Order Application	/Application/application_list/2/in	\N	16
30	Update Status	/Application/application_list/6/in	\N	18
31	Offline Application Entry	/Application/offlineEntry	\N	19
32	View Offline Applications	/Application/viewOfflineApplications	\N	20
15	Home	/Application/index	\N	1
24	Create Tasks	/Task/createTask	23	1
25	View Tasks	/Task/viewTasks	23	2
26	Process Task Mapping	/Task/ProcessTaskMapping	23	3
1	View Users	/user/viewUsers	\N	2
2	Add User	/user/addUsers	\N	3
3	Add Roles	/role/addRoles	\N	4
5	Menu	/Menu/displayMenu	\N	5
9	Certificate Preparation	/Application/application_list/5/in	\N	9
7	Apply for copy	/application/apply	\N	11
8	View Applications	/application/viewApplications	\N	12
23	Tasks	/Menu/displayMenu	\N	14
\.


--
-- TOC entry 3072 (class 0 OID 17219)
-- Dependencies: 214
-- Data for Name: menu_role_mapping; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menu_role_mapping (menu_id, role_id, menu_role_mapping_id) FROM stdin;
2	1	93
16	1	94
21	1	100
22	1	101
23	1	102
15	1	104
15	14	105
15	9	106
15	12	107
15	2	108
15	7	109
15	4	110
15	5	111
15	6	112
15	17	113
15	3	114
15	11	115
15	8	116
15	13	117
17	2	118
5	1	35
3	1	36
4	1	38
1	1	39
6	14	40
7	14	41
8	14	42
10	2	44
12	2	46
13	4	47
13	5	48
13	6	49
9	12	124
14	7	125
33	10	130
34	11	131
27	14	132
28	9	133
29	11	134
30	2	135
31	2	136
32	2	137
\.


--
-- TOC entry 3074 (class 0 OID 17225)
-- Dependencies: 216
-- Data for Name: offline_application; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.offline_application (application_id, applicant_name, offline_application_id, aadhaar) FROM stdin;
MNHC0202-2020-U3q3UE	Khumanthem Lakhikanta	1	763384620896
MNHC0202-2020-21E16d	Toman Chanambam	2	763384620896
MNHC0202-2020-04M557	Khangembam Johnny	3	763384620896
MNHC0202-2020-e2G215	Sanjembam Bobo	4	875659693559
MNHC0202-2020-39399J	Tompok	5	763384620895
MNHC0202-2020-226897	Konsam Gulson Singh	6	746321879654
MNHC02-2020-C25478	Konsam Gulson Singh	7	763384620896
MNHC02-2020-7283eP	Yurembam Toman	8	746321879654
MNHC02-2020-tt4361	Yumnam Tony	9	746321879654
MNHC02-2020-6I5655	Heikrujam Manitomba	10	875659693559
MNHC02-2020-b586FF	Alice	11	746321879654
MNHC03-2020-184455	Chongtham Gitchandra	12	463266652315
\.


--
-- TOC entry 3075 (class 0 OID 17228)
-- Dependencies: 217
-- Data for Name: offline_payment_receipt; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.offline_payment_receipt (offline_payment_receipt_id, receipt_path, application_id, created_at) FROM stdin;
1	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC0202-2020-e2G215/BCM new Notice.pdf	MNHC0202-2020-e2G215	2020-02-25 17:10:34+05:30
2	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC0202-2020-39399J/Phamthoibi.pdf	MNHC0202-2020-39399J	2020-02-25 17:13:34+05:30
3	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC0202-2020-U3q3UE/priya.pdf	MNHC0202-2020-U3q3UE	2020-02-26 19:09:57+05:30
4	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC0202-2020-21E16d/Manda.pdf	MNHC0202-2020-21E16d	2020-02-26 19:27:55+05:30
5	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC0202-2020-04M557/priya.pdf	MNHC0202-2020-04M557	2020-02-26 20:02:20+05:30
6	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC02-2020-7283eP/Payment History.pdf	MNHC02-2020-7283eP	2020-02-26 20:36:49+05:30
7	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC02-2020-C25478/MPR_JAN_2018.pdf	MNHC02-2020-C25478	2020-02-26 20:48:29+05:30
8	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC02-2020-tt4361/invoice.pdf	MNHC02-2020-tt4361	2020-02-27 11:34:06+05:30
9	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC02-2020-6I5655/doc.pdf	MNHC02-2020-6I5655	2020-02-27 12:28:44+05:30
10	C:\\xampp\\htdocs\\copying.nic.in\\Uploads/documents/receipt/MNHC02-2020-b586FF/doc.pdf	MNHC02-2020-b586FF	2020-02-27 15:02:36+05:30
\.


--
-- TOC entry 3076 (class 0 OID 17231)
-- Dependencies: 218
-- Data for Name: payable_amount; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payable_amount (payable_amount_id, purpose, amount) FROM stdin;
2	per page	1
1	certificate processing fee	80
\.


--
-- TOC entry 3078 (class 0 OID 17236)
-- Dependencies: 220
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (payments_id, payment_type, amount, purpose, application_id, transaction_id, status, created_at, payment_date) FROM stdin;
1	online	20	Certificate Processing fee	certificate processing fee	9M183202WE298173L	Completed	2020-02-05 16:52:36+05:30	00:00:08 Feb 05, 2020 PST
2	online	20	Certificate Processing fee	acd8118b-d4af-4bd4-bacb-f9d708c0afdc	4MT09621NM333422J	Completed	2020-02-05 16:56:39+05:30	03:26:30 Feb 05, 2020 PST
3	online	20	Certificate Processing fee	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	0JT58222F4646351H	Completed	2020-02-06 11:32:07+05:30	22:01:58 Feb 05, 2020 PST
4	online	20	Certificate Processing fee	a3280206-6f0d-4c41-8e62-7adf80c36234	77433783VY4315837	Completed	2020-02-10 12:48:29+05:30	23:07:56 Feb 09, 2020 PST
5	online	20	Certificate Processing fee	af2fbbea-4f9f-4ec3-a53b-558215f67e18	01429698HX146553P	Completed	2020-02-10 12:54:28+05:30	23:24:19 Feb 09, 2020 PST
6	online	20	Certificate Processing fee	14750714-5dc6-4e12-9240-dca5c378b3bd	8AR32762GA753461M	Completed	2020-02-12 14:25:24+05:30	00:55:07 Feb 12, 2020 PST
7	online	20	Certificate Processing fee	83e41810-e4da-41c9-b040-fac31b87057b	3GX71442PX2293251	Completed	2020-02-12 14:31:21+05:30	01:01:12 Feb 12, 2020 PST
8	online	20	Certificate Processing fee	68a4fbfd-a174-4171-a059-7f9624259753	1CA89234B2045202Y	Completed	2020-02-12 16:30:55+05:30	03:00:47 Feb 12, 2020 PST
9	offline	20	Certificate processing fee	MNHC0202-2020-e2G215	OFF-02-202057511e	Completed	2020-02-25 17:10:34+05:30	2020-02-25 17:10:34
10	offline	20	Certificate processing fee	MNHC0202-2020-39399J	OFF-02-2020J046j8	Completed	2020-02-25 17:13:34+05:30	2020-02-25 17:13:34
11	offline	20	Certificate processing fee	MNHC0202-2020-U3q3UE	OFF-02-20205d17b5	Completed	2020-02-26 19:09:57+05:30	2020-02-26 19:09:57
12	offline	40	Certificate processing fee	MNHC0202-2020-21E16d	OFF-02-202072b744	Completed	2020-02-26 19:27:55+05:30	2020-02-26 19:27:55
13	offline	20	Certificate processing fee	MNHC0202-2020-04M557	OFF-02-202025110b	Completed	2020-02-26 20:02:20+05:30	2020-02-26 20:02:20
14	offline	20	Certificate processing fee	MNHC02-2020-7283eP	OFF-02-2020299i65	Completed	2020-02-26 20:36:49+05:30	2020-02-26 20:36:49
15	offline	20	Certificate processing fee	MNHC02-2020-C25478	OFF-02-20203799m0	Completed	2020-02-26 20:48:29+05:30	2020-02-26 20:48:29
16	offline	20	Certificate processing fee	MNHC02-2020-tt4361	OFF-02-2020te05f5	Completed	2020-02-27 11:34:06+05:30	2020-02-27 11:34:06
17	offline	20	Certificate processing fee	MNHC02-2020-6I5655	OFF-02-2020926568	Completed	2020-02-27 12:28:44+05:30	2020-02-27 12:28:44
18	online	20	Certificate Processing fee	MNHC02-2020-8W4148	4WA66192LM798005R	Completed	2020-02-27 14:37:50+05:30	01:07:20 Feb 27, 2020 PST
19	offline	20	Certificate processing fee	MNHC02-2020-b586FF	OFF-02-202085X98H	Completed	2020-02-27 15:02:36+05:30	2020-02-27 15:02:36
20	online	80	Certificate Processing fee	f955c735-4183-4b79-8ed3-c4dbd0e07de1	3YT45182DN949194L	Completed	2020-03-17 14:09:02+05:30	01:38:46 Mar 17, 2020 PDT
\.


--
-- TOC entry 3080 (class 0 OID 17244)
-- Dependencies: 222
-- Data for Name: process; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.process (process_id, process_name, process_description, number_of_role) FROM stdin;
2	Application for order copy	To receive application for order copy	1
1	Application for non order non third party copy	To receive application for not order copy	2
3	Application for non order third party copy	non order third party copy 	\N
\.


--
-- TOC entry 3083 (class 0 OID 17254)
-- Dependencies: 225
-- Data for Name: process_tasks_mapping; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.process_tasks_mapping (process_tasks_mapping_id, process_id, tasks_id, priority_level, is_enabled) FROM stdin;
24	1	1	2	y
25	1	3	3	y
26	1	4	4	y
27	1	5	5	y
28	1	6	6	y
18	3	1	1	y
19	3	2	2	y
20	3	3	3	y
21	3	4	4	y
22	3	5	5	y
23	3	6	6	y
1	2	1	2	y
2	2	3	3	y
3	2	5	4	y
4	2	6	5	y
\.


--
-- TOC entry 3085 (class 0 OID 17269)
-- Dependencies: 228
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role (role_id, role_name) FROM stdin;
1	Admin
2	Copying Section
4	Judicial 1
5	Judicial 2
6	Judicial 3
7	Jr. AA
8	Sr. AA
10	Deputy Registrar Judicial
11	Registrar Judicial
12	Computer Operator
13	Superintendent
14	Applicant
3	Registrar General (RG)
9	Assistant Registrar
18	Record Keeper
17	Junior Administrative Assistant
\.


--
-- TOC entry 3087 (class 0 OID 17275)
-- Dependencies: 230
-- Data for Name: status; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.status (status_id, description, created_at, updated_at, deleted_at, application_id, user_id) FROM stdin;
2	You can collect your application on 15th Feb, 2020 from copying section.	2020-02-11 16:00:28+05:30	\N	\N	af2fbbea-4f9f-4ec3-a53b-558215f67e18	80bd49f7-a31c-4902-88f0-16cbc9740c8c
1	You can collect your application on 25th Feb, 2020 from copying section.	2020-02-11 15:57:34+05:30	\N	\N	1fcb7ec7-90d0-4c0f-a775-62a07ff0656b	80bd49f7-a31c-4902-88f0-16cbc9740c8c
3	You can take your certificate on 3rd March 2020	2020-02-27 13:40:10+05:30	\N	\N	MNHC02-2020-tt4361	80bd49f7-a31c-4902-88f0-16cbc9740c8c
4	Come today	2020-03-19 16:46:11+05:30	\N	\N	MNHC02-2020-8W4148	80bd49f7-a31c-4902-88f0-16cbc9740c8c
5	Your application is completed	2020-07-16 14:25:43+05:30	\N	\N	MNHC02-2020-7283eP	80bd49f7-a31c-4902-88f0-16cbc9740c8c
\.


--
-- TOC entry 3084 (class 0 OID 17258)
-- Dependencies: 226
-- Data for Name: tasks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tasks (tasks_id, tasks_name, tasks_description, create_at, update_at, delete_at, user_id) FROM stdin;
3	Receive Applications	Copying Section receiving applications	2020-01-28 12:53:38+05:30	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
5	Prepare Certificate	Certificate Preparation	2020-01-28 12:55:53+05:30	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
2	Approve Non Order Third Party Application	Assistant Registrar receives third party non-order application	2020-01-28 12:51:57+05:30	2020-01-28 13:27:07+05:30	\N	c43846c6-69ba-4161-9f06-a5f801791796
4	Registrar Judicial	Approval of application for Non-Order copy by Registrar Judicial.	2020-01-28 12:55:18+05:30	2020-01-31 11:37:16+05:30	\N	c43846c6-69ba-4161-9f06-a5f801791796
6	Update Status	Update application status.	2020-01-28 12:57:21+05:30	2020-01-31 11:42:09+05:30	\N	c43846c6-69ba-4161-9f06-a5f801791796
1	Apply For Copy	Submition of application for Copy	2020-01-28 12:49:24+05:30	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
\.


--
-- TOC entry 3089 (class 0 OID 17281)
-- Dependencies: 232
-- Data for Name: tasks_role_mapping; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tasks_role_mapping (tasks_role_mapping_id, tasks_id, role_id) FROM stdin;
1	1	14
3	3	2
5	5	12
9	2	9
10	4	11
11	6	2
\.


--
-- TOC entry 3090 (class 0 OID 17285)
-- Dependencies: 233
-- Data for Name: third_party_applicant_reasons; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.third_party_applicant_reasons (third_party_application_reasons_id, application_id, reason) FROM stdin;
1	MNHC0202-2020-f516c0	For use in appeal
2	MNHC0202-2020-W5W575	For use in appeal
3	MNHC0202-2020-U3q3UE	Just for testing
4	MNHC0202-2020-21E16d	I have to use this in some other purpose.
5	MNHC0202-2020-04M557	Just for testing
6	MNHC0202-2020-e2G215	For use in appeal
7	MNHC0202-2020-39399J	I have to use this in some other purpose.
8	MNHC0202-2020-226897	For use in the lower court or subordinate court for legal proceeding
9	MNHC02-2020-C25478	For use in department
10	MNHC02-2020-7283eP	I have to use this in some other purpose.
11	MNHC02-2020-tt4361	personal use
12	MNHC02-2020-6I5655	For personal use
13	MNHC02-2020-8W4148	For applying review petition
14	MNHC03-2020-Q31542	For official use
15	MNHC04-2020-6e1056	For use in appeal
\.


--
-- TOC entry 3092 (class 0 OID 17290)
-- Dependencies: 235
-- Data for Name: third_party_reasons; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.third_party_reasons (third_party_reasons_id, reasons) FROM stdin;
3	For use as legal notice to office or department
1	For applying review petition
4	For use in the lower court or subordinate court for legal proceeding
2	For use in appeal
\.


--
-- TOC entry 3066 (class 0 OID 17187)
-- Dependencies: 206
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, full_name, email, phone_number, role_id, user_password, verify, create_at, update_at, delete_at, profile_image, aadhaar, update_by) FROM stdin;
f238775f-6e77-4df4-871d-7fb6fe8112b9	Khangenbam Nganthoiba	leecba@gmail.com	9089517468	14	82a3326339cfd75bdc0a667e21957437c58de70a5514aead2f8d2ed93f1fbd90	f	2019-12-05 18:58:42.532194+05:30	2020-02-20 14:51:44+05:30	\N	\N	763384620895	f238775f-6e77-4df4-871d-7fb6fe8112b9
6c6ca4dd-0ef6-4584-8d01-ea922578fa20	Computer Operator	co@gmail.com	9856732169	12	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 09:11:04.92005+05:30	2020-01-27 14:32:52+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
030c2683-8ff2-47f8-81fa-f05dd8657f58	Firstname Judicial 1	judicial1@gmail.com	9876541236	4	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-10 07:02:14.553172+05:30	2020-01-12 10:02:41+05:30	\N	\N	\N	030c2683-8ff2-47f8-81fa-f05dd8657f58
dc6e8456-7fc5-472d-adde-28939b3da901	Registrar General	rg@gmail.com	5423368788	3	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 13:55:58.697748+05:30	2019-12-15 22:43:23+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
e4b7fc43-406d-437b-a946-a22d7bc52d38	Assistant Registrar	assistant_rg@gmail.com	5641239772	9	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 14:00:11.947769+05:30	2020-02-20 15:03:54+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
003c8504-caad-4e36-a34e-a1cc54f9e4ce	Superintendent	sp@gmail.com	5641237895	13	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 13:58:46.373194+05:30	2019-12-15 22:55:47+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
900985bb-b940-4c59-b11f-75413b3414d5	Laishram Bonita	bonita@gmail.com	9856732164	12	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-15 22:58:04.069324+05:30	\N	\N	\N	\N	\N
1d6ce7ba-7161-487f-b566-7202e9222174	Firstname Judicial 2	judicial2@gmail.com	9089517462	5	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-10 07:03:48.018414+05:30	2020-01-27 18:48:24+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
f9f63fae-b09d-41bf-a915-9aa75fd40f0f	Khuraijam Siddhart	siddhart@yahoo.in	9856732148	2	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-16 21:29:29.229472+05:30	2020-01-13 14:19:28+05:30	\N	\N	\N	f9f63fae-b09d-41bf-a915-9aa75fd40f0f
aa02b8ca-6da7-4088-b8c4-75d5c4cb09f9	Khangembam Thoibi	thoibi@gmail.com	9856732169	9	f565df210b29157d76cf761e29f4909ad7a8704949b071fe12e98576ca76e48f	f	2019-12-09 15:37:14.82123+05:30	2019-12-29 20:32:34+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
48739a8c-2156-4a51-86a7-520c09a737d8	Ningthoujam Monica	monica@gmail.com	9856732148	4	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-20 12:23:12.691221+05:30	\N	\N	\N	\N	\N
e0574765-71c6-4a9b-ad0a-1d9ab8772148	Priti	priti@gmail.com	8794354828	3	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-18 19:24:19.884495+05:30	2020-01-16 07:58:36+05:30	\N	\N	763384620896	c43846c6-69ba-4161-9f06-a5f801791796
6e6cae79-b531-4596-bcbe-4cc5522c1536	Yendrembam Lumfu	lumfu@gmail.com	9856732148	14	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-20 14:29:20.550335+05:30	\N	\N	\N	\N	\N
7131442f-54a7-418f-9170-0eb8c7fd30dd	Mr. Deputy Registrar Judicial	deputy_rg@gmail.com	4561789322	10	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 14:03:15.716994+05:30	2020-01-16 08:30:42+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
c43846c6-69ba-4161-9f06-a5f801791796	Administrator	admin@gmail.com	9856732169	1	8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918	f	2019-12-05 19:01:10.340154+05:30	2020-04-18 19:30:02+05:30	\N	\N	123456789167	c43846c6-69ba-4161-9f06-a5f801791796
e40a7414-8020-4472-8669-767db5f90979	Junior Administrative Assistant	jraa@gmail.com	2364178958	7	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 13:56:46.565739+05:30	2020-03-29 15:46:56+05:30	\N	\N	\N	c43846c6-69ba-4161-9f06-a5f801791796
384218d0-546a-4561-8c92-6a9738f0f796	Senior Account Assistant	sraa@gmail.com	5497336478	8	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 13:57:57.279107+05:30	\N	\N	\N	\N	\N
c613e2e4-84bc-4ccb-95e6-f7a8ca624a25	Registrar Judicial	rg_judicial@gmail.com	1234567895	11	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-09 14:05:23.704717+05:30	\N	\N	\N	\N	\N
514d2016-34ff-4a20-8277-d61af58a171a	Khangembam Alex	alex@gmail.com	9856732169	14	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-12 11:21:37.511122+05:30	2019-12-12 13:06:09+05:30	\N	\N	526425502565	514d2016-34ff-4a20-8277-d61af58a171a
2b62c813-5631-4ae8-856a-300146a29121	Judicial 3	judicial3@gmail.com	9874123598	6	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-10 07:04:50.591067+05:30	\N	\N	\N	\N	\N
c039de78-d396-4156-94ef-11f67c5991d9	Khangembam Alica	alica@gmail.com	9856732167	14	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-23 13:01:04.436267+05:30	2020-06-28 15:21:34+05:30	\N	\N	479532148976	c039de78-d396-4156-94ef-11f67c5991d9
80bd49f7-a31c-4902-88f0-16cbc9740c8c	Oinam Ibobi Singh	ibobi@gmail.com	7854621389	2	a6864eb339b0e1f6e00d75293a8840abf069a2c0fe82e6e53af6ac099793c1d5	f	2019-12-10 07:05:58.198767+05:30	2020-08-08 19:21:57+05:30	\N	\N	763384620891	80bd49f7-a31c-4902-88f0-16cbc9740c8c
\.


--
-- TOC entry 3166 (class 0 OID 0)
-- Dependencies: 197
-- Name: Document_document_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Document_document_id_seq"', 1, false);


--
-- TOC entry 3167 (class 0 OID 0)
-- Dependencies: 198
-- Name: Process_Tasks_Mapping_process_tasks_mapping_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Process_Tasks_Mapping_process_tasks_mapping_id_seq"', 1, false);


--
-- TOC entry 3168 (class 0 OID 0)
-- Dependencies: 199
-- Name: Tasks_Role_Mapping_tasks_role_mapping_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Tasks_Role_Mapping_tasks_role_mapping_id_seq"', 1, false);


--
-- TOC entry 3169 (class 0 OID 0)
-- Dependencies: 202
-- Name: application_for_application_for_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.application_for_application_for_id_seq', 1, false);


--
-- TOC entry 3170 (class 0 OID 0)
-- Dependencies: 209
-- Name: case_body_case_body_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.case_body_case_body_id_seq', 1, false);


--
-- TOC entry 3171 (class 0 OID 0)
-- Dependencies: 213
-- Name: menu_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_menu_id_seq', 1, false);


--
-- TOC entry 3172 (class 0 OID 0)
-- Dependencies: 215
-- Name: menu_role_mapping_menu_role_mapping_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menu_role_mapping_menu_role_mapping_id_seq', 137, true);


--
-- TOC entry 3173 (class 0 OID 0)
-- Dependencies: 219
-- Name: payable_amount_payable_amount_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payable_amount_payable_amount_id_seq', 2, true);


--
-- TOC entry 3174 (class 0 OID 0)
-- Dependencies: 221
-- Name: payments_payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_payments_id_seq', 1, false);


--
-- TOC entry 3175 (class 0 OID 0)
-- Dependencies: 223
-- Name: process_process_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.process_process_id_seq', 1, true);


--
-- TOC entry 3176 (class 0 OID 0)
-- Dependencies: 224
-- Name: process_role_map_process_role_map_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.process_role_map_process_role_map_id_seq', 1, true);


--
-- TOC entry 3177 (class 0 OID 0)
-- Dependencies: 229
-- Name: roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_role_id_seq', 2, true);


--
-- TOC entry 3178 (class 0 OID 0)
-- Dependencies: 231
-- Name: status_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.status_status_id_seq', 1, false);


--
-- TOC entry 3179 (class 0 OID 0)
-- Dependencies: 234
-- Name: third_party_application_reaso_third_party_application_reaso_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.third_party_application_reaso_third_party_application_reaso_seq', 1, false);


--
-- TOC entry 3180 (class 0 OID 0)
-- Dependencies: 236
-- Name: third_party_reasons_third_party_reasons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.third_party_reasons_third_party_reasons_id_seq', 1, true);


--
-- TOC entry 2877 (class 2606 OID 17310)
-- Name: document Document_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.document
    ADD CONSTRAINT "Document_pkey" PRIMARY KEY (document_id);


--
-- TOC entry 2916 (class 2606 OID 17312)
-- Name: process_tasks_mapping Process_Task_Mapping_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.process_tasks_mapping
    ADD CONSTRAINT "Process_Task_Mapping_pkey" PRIMARY KEY (process_tasks_mapping_id);


--
-- TOC entry 2924 (class 2606 OID 17314)
-- Name: tasks_role_mapping Tasks_Role_Mapping_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tasks_role_mapping
    ADD CONSTRAINT "Tasks_Role_Mapping_pkey" PRIMARY KEY (tasks_role_mapping_id);


--
-- TOC entry 2918 (class 2606 OID 17316)
-- Name: tasks Tasks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT "Tasks_pkey" PRIMARY KEY (tasks_id);


--
-- TOC entry 2881 (class 2606 OID 17318)
-- Name: certificate_type application_for_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.certificate_type
    ADD CONSTRAINT application_for_pkey PRIMARY KEY (certificate_type_id);


--
-- TOC entry 2879 (class 2606 OID 17320)
-- Name: application applications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application
    ADD CONSTRAINT applications_pkey PRIMARY KEY (application_id);


--
-- TOC entry 2883 (class 2606 OID 17322)
-- Name: application_tasks_log applications_tasks_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_tasks_log
    ADD CONSTRAINT applications_tasks_log_pkey PRIMARY KEY (application_tasks_log_id);


--
-- TOC entry 2896 (class 2606 OID 17324)
-- Name: casebody case_body_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.casebody
    ADD CONSTRAINT case_body_pkey PRIMARY KEY (casebody_id);


--
-- TOC entry 2898 (class 2606 OID 17326)
-- Name: casebody case_body_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.casebody
    ADD CONSTRAINT case_body_unique UNIQUE (case_type_id, case_number, case_year);


--
-- TOC entry 2886 (class 2606 OID 17328)
-- Name: case_type case_type_t_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.case_type
    ADD CONSTRAINT case_type_t_pkey PRIMARY KEY (case_type_id);


--
-- TOC entry 2889 (class 2606 OID 17330)
-- Name: copy_type certificate_copy_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.copy_type
    ADD CONSTRAINT certificate_copy_types_pkey PRIMARY KEY (copy_type_id);


--
-- TOC entry 2900 (class 2606 OID 17332)
-- Name: logins login_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logins
    ADD CONSTRAINT login_pkey PRIMARY KEY (login_id);


--
-- TOC entry 2902 (class 2606 OID 17334)
-- Name: menu menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (menu_id);


--
-- TOC entry 2904 (class 2606 OID 17336)
-- Name: menu_role_mapping menu_role_mapping_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_role_mapping
    ADD CONSTRAINT menu_role_mapping_pkey PRIMARY KEY (menu_role_mapping_id);


--
-- TOC entry 2906 (class 2606 OID 17338)
-- Name: offline_application offline_application_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offline_application
    ADD CONSTRAINT offline_application_pkey PRIMARY KEY (offline_application_id);


--
-- TOC entry 2908 (class 2606 OID 17340)
-- Name: offline_payment_receipt offline_payment_receipt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offline_payment_receipt
    ADD CONSTRAINT offline_payment_receipt_pkey PRIMARY KEY (offline_payment_receipt_id);


--
-- TOC entry 2910 (class 2606 OID 17342)
-- Name: payable_amount payable_amount_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payable_amount
    ADD CONSTRAINT payable_amount_pkey PRIMARY KEY (payable_amount_id);


--
-- TOC entry 2912 (class 2606 OID 17344)
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (payments_id);


--
-- TOC entry 2914 (class 2606 OID 17346)
-- Name: process process_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.process
    ADD CONSTRAINT process_pkey1 PRIMARY KEY (process_id);


--
-- TOC entry 2920 (class 2606 OID 17348)
-- Name: role roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role
    ADD CONSTRAINT roles_pkey PRIMARY KEY (role_id);


--
-- TOC entry 2922 (class 2606 OID 17350)
-- Name: status status_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.status
    ADD CONSTRAINT status_pkey PRIMARY KEY (status_id);


--
-- TOC entry 2926 (class 2606 OID 17352)
-- Name: third_party_applicant_reasons third_party_application_reasons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.third_party_applicant_reasons
    ADD CONSTRAINT third_party_application_reasons_pkey PRIMARY KEY (third_party_application_reasons_id);


--
-- TOC entry 2928 (class 2606 OID 17354)
-- Name: third_party_reasons third_party_reasons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.third_party_reasons
    ADD CONSTRAINT third_party_reasons_pkey PRIMARY KEY (third_party_reasons_id);


--
-- TOC entry 2892 (class 2606 OID 17356)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 2894 (class 2606 OID 17358)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 2890 (class 1259 OID 17359)
-- Name: aadhaar_unique; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX aadhaar_unique ON public.users USING btree (aadhaar);


--
-- TOC entry 2884 (class 1259 OID 17360)
-- Name: case_type_case_type_t; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX case_type_case_type_t ON public.case_type USING btree (case_type_id);


--
-- TOC entry 2887 (class 1259 OID 17361)
-- Name: type_flag_case_type_t; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX type_flag_case_type_t ON public.case_type USING btree (type_flag);


--
-- TOC entry 2929 (class 2606 OID 17362)
-- Name: menu menu_self_reference; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu
    ADD CONSTRAINT menu_self_reference FOREIGN KEY (parent_menu_id) REFERENCES public.menu(menu_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2930 (class 2606 OID 17367)
-- Name: offline_application offline_application_foreign_key; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offline_application
    ADD CONSTRAINT offline_application_foreign_key FOREIGN KEY (application_id) REFERENCES public.application(application_id) ON UPDATE CASCADE ON DELETE CASCADE;


-- Completed on 2020-09-10 12:55:18

--
-- PostgreSQL database dump complete
--

