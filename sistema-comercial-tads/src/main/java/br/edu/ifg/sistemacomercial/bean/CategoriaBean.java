package br.edu.ifg.sistemacomercial.bean;

import br.edu.ifg.sistemacomercial.dao.CategoriaDAO;
import br.edu.ifg.sistemacomercial.entity.Categoria;
import br.edu.ifg.sistemacomercial.util.JsfUtil;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import javax.annotation.PostConstruct;
import javax.faces.bean.ManagedBean;
import javax.faces.bean.SessionScoped;

@ManagedBean
@SessionScoped
public class CategoriaBean extends JsfUtil{
    
    private Categoria categoria;
    private List<Categoria> categorias;
    
    private CategoriaDAO categoriaDAO;
    
    @PostConstruct
    public void init(){
        categoria = new Categoria();
        categorias = new ArrayList<>();   
        categoriaDAO = new CategoriaDAO();
    }
    
    public void novo(){
        categoria = new Categoria();
    }

    public void adicionarCategoria(){
        try {
            categoriaDAO.salvar(categoria);
            categoria = new Categoria();
            addMensagem("Salvo com sucesso!");
            pesquisar();
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
        }
    }
    
    public void remover(Categoria categoria){
        try {
            categoriaDAO.deletar(categoria);
            categorias.remove(categoria);
            addMensagem("Deletado com sucesso!");
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
        }
    }
    public void editar(Categoria categoria){
        //remover(usuario);
        this.categoria = categoria;
    }
    
    public void pesquisar(){
        try {            
            categorias = categoriaDAO.listar();
            if(categorias == null || categorias.isEmpty()){
                addMensagemAviso("Nenhum cadastrado.");
            }
        } catch (SQLException ex) {
            addMensagemErro(ex.getMessage());
        }
    }
    
    public Categoria getCategoria() {
        return categoria;
    }

    public void setCategoria(Categoria categoria) {
        this.categoria = categoria;
    }

    public List<Categoria> getCategorias() {
        return categorias;
    }
    
}
